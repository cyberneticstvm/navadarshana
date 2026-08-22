<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ClassSchedule;
use App\Models\Course;
use App\Models\CourseTopic;
use App\Models\DailyCurrentAffair;
use App\Models\Download;
use App\Models\Extra;
use App\Models\Fee;
use App\Models\Note;
use App\Models\Question;
use App\Models\Student;
use App\Models\StudentBatch;
use App\Models\StudentFeedback;
use App\Models\Syllabus;
use App\Models\VideoRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class StudentAreaController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('student-notes-register'), only: ['getStudentNotes']),
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('Student'), only: ['showProfile', 'getClassSchedules', 'getFeeDetails', 'exportFeeDetails', 'getFeedbacks', 'submitFeedback', 'getRecordedVideos', 'getDownloads', 'getQuestions', 'getCurrentAffairs']),
        ];
    }

    function showProfile()
    {
        $student = Student::with(['idType', 'branch', 'activeBatches.batch.course'])
            ->findOrFail(Auth::user()->student_id);
        $activeBatches = $student->activeBatches
            ->filter(fn ($enrollment) => $enrollment->batch !== null);

        $photoUrl = null;
        if ($student->photo) {
            $photoUrl = str_starts_with($student->photo, 'http')
                ? $student->photo
                : gcsPublicUrl() . $student->photo;
        }

        return view('student.zone.profile', compact('student', 'activeBatches', 'photoUrl'));
    }

    function getClassSchedules(Request $request)
    {
        $student = Student::findOrFail(Auth::user()->student_id);

        $enrolledBatches = Batch::with('course')
            ->where('branch_id', $student->branch_id)
            ->whereIn('id', StudentBatch::where('student_id', $student->id)->pluck('batch_id'))
            ->orderBy('name')
            ->get();

        $batchIds = $enrolledBatches->pluck('id');
        $selectedBatch = $request->integer('batch');

        if ($selectedBatch && !$batchIds->contains($selectedBatch)) {
            $selectedBatch = 0;
        }

        $schedules = ClassSchedule::with(['batch.course', 'faculty', 'syllabus'])
            ->where('branch_id', $student->branch_id)
            ->whereIn('batch_id', $batchIds)
            ->whereDate('date', '>=', now()->toDateString())
            ->when($selectedBatch, function ($query) use ($selectedBatch) {
                return $query->where('batch_id', $selectedBatch);
            })
            ->orderBy('date')
            ->orderBy('from_time')
            ->paginate(20)
            ->withQueryString();

        return view('student.zone.class-schedule', compact(
            'enrolledBatches',
            'schedules',
            'selectedBatch'
        ));
    }

    function getFeeDetails()
    {
        $student = Student::findOrFail(Auth::user()->student_id);

        $fees = $this->studentFeeQuery($student)
            ->paginate(20);

        $summary = $this->studentFeeQuery($student)
            ->selectRaw('COUNT(*) AS payments, COALESCE(SUM(amount), 0) AS amount, COALESCE(SUM(discount), 0) AS discount, COALESCE(SUM(amount - COALESCE(discount, 0)), 0) AS paid')
            ->first();

        return view('student.zone.fee-details', compact('student', 'fees', 'summary'));
    }

    function exportFeeDetails()
    {
        $student = Student::with('branch')->findOrFail(Auth::user()->student_id);
        $fees = $this->studentFeeQuery($student)->get();

        $pdf = Pdf::loadView('pdf.student-fee-details', compact('student', 'fees'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('fee-statement-ND-' . str_pad($student->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    private function feeQuery(Student $student)
    {
        return Fee::with(['batch.course', 'pmode', 'getMonth'])
            ->where('student_id', $student->id)
            ->orderByDesc('payment_date')
            ->orderByDesc('id');
    }

    private function studentFeeQuery(Student $student)
    {
        return $this->feeQuery($student)
            ->when(!$student->show_all_fees, function ($query) {
                return $query->whereIn('type', ['advance', 'balance']);
            });
    }

    function getFeedbacks()
    {
        $student = Student::findOrFail(Auth::user()->student_id);
        $feedbacks = StudentFeedback::with('responder')
            ->where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('student.zone.feedback', compact('feedbacks'));
    }

    function submitFeedback(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'feedback' => 'required|string|max:5000',
        ]);

        $student = Student::findOrFail(Auth::user()->student_id);
        StudentFeedback::create([
            'student_id' => $student->id,
            'subject' => $request->subject,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('student.feedback')
            ->with('success', 'Feedback submitted successfully.');
    }

    function getRecordedVideos(Request $request)
    {
        $student = Student::findOrFail(Auth::user()->student_id);

        $courseIds = Batch::where('branch_id', $student->branch_id)
            ->whereIn('id', StudentBatch::where('student_id', $student->id)->pluck('batch_id'))
            ->pluck('course_id');

        $syllabusIds = CourseTopic::join('topics as topics', 'course_topics.topic_id', '=', 'topics.id')
            ->join('modules as modules', 'topics.module_id', '=', 'modules.id')
            ->whereIn('course_topics.course_id', $courseIds)
            ->whereNull('topics.deleted_at')
            ->whereNull('modules.deleted_at')
            ->whereNotNull('modules.syllabus_id')
            ->distinct()
            ->pluck('modules.syllabus_id');

        $syllabi = Syllabus::whereIn('id', $syllabusIds)
            ->orderBy('name')
            ->get();

        $selectedSyllabus = $request->integer('syllabus');
        if ($selectedSyllabus && !$syllabi->pluck('id')->contains($selectedSyllabus)) {
            $selectedSyllabus = 0;
        }

        $videos = VideoRecord::with('syllabus')
            ->whereIn('syllabus_id', $syllabusIds)
            ->when($selectedSyllabus, fn ($query) => $query->where('syllabus_id', $selectedSyllabus))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('student.zone.recorded-videos', compact(
            'syllabi',
            'videos',
            'selectedSyllabus'
        ));
    }

    function getDownloads(Request $request)
    {
        $student = Student::findOrFail(Auth::user()->student_id);
        $courseIds = $this->studentCourseIds($student);

        $courses = Course::whereIn('id', $courseIds)
            ->orderBy('name')
            ->get();

        $selectedCourse = $request->integer('course');
        if ($selectedCourse && !$courses->pluck('id')->contains($selectedCourse)) {
            $selectedCourse = 0;
        }

        $downloads = Download::with('course')
            ->whereIn('course_id', $courseIds)
            ->when($selectedCourse, fn ($query) => $query->where('course_id', $selectedCourse))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('student.zone.downloads', compact('courses', 'downloads', 'selectedCourse'));
    }

    function getQuestions(Request $request)
    {
        $student = Student::findOrFail(Auth::user()->student_id);
        $courseIds = $this->studentCourseIds($student);

        $courseContent = CourseTopic::join('topics as topics', 'course_topics.topic_id', '=', 'topics.id')
            ->join('modules as modules', 'topics.module_id', '=', 'modules.id')
            ->whereIn('course_topics.course_id', $courseIds)
            ->whereNull('topics.deleted_at')
            ->whereNull('modules.deleted_at')
            ->select('course_topics.topic_id', 'modules.syllabus_id')
            ->distinct()
            ->get();

        $topicIds = $courseContent->pluck('topic_id');
        $syllabusIds = $courseContent->pluck('syllabus_id')->filter()->unique()->values();
        $syllabi = Syllabus::whereIn('id', $syllabusIds)->orderBy('name')->get();
        $questionTypes = Extra::where('name', 'qtype')->orderBy('value')->get();

        $selectedSyllabus = $request->integer('syllabus');
        if ($selectedSyllabus && !$syllabi->pluck('id')->contains($selectedSyllabus)) {
            $selectedSyllabus = 0;
        }

        $selectedType = $request->integer('type');
        if ($selectedType && !$questionTypes->pluck('id')->contains($selectedType)) {
            $selectedType = 0;
        }

        $questions = Question::with(['syllabus', 'module', 'topic', 'options'])
            ->whereIn('topic_id', $topicIds)
            ->whereIn('syllabus_id', $syllabusIds)
            ->when($selectedSyllabus, fn ($query) => $query->where('syllabus_id', $selectedSyllabus))
            ->when($selectedType, fn ($query) => $query->where('type_id', $selectedType))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('student.zone.questions', compact(
            'syllabi',
            'questionTypes',
            'questions',
            'selectedSyllabus',
            'selectedType'
        ));
    }

    private function studentCourseIds(Student $student)
    {
        return Batch::where('branch_id', $student->branch_id)
            ->whereIn('id', StudentBatch::where('student_id', $student->id)->pluck('batch_id'))
            ->pluck('course_id')
            ->filter()
            ->unique()
            ->values();
    }

    function getCurrentAffairs()
    {
        $currentAffairs = DailyCurrentAffair::latest()
            ->paginate(10);

        return view('student.zone.current-affairs', compact('currentAffairs'));
    }

    function getStudentNotes()
    {
        $student = Student::findOrFail(Auth::user()->student_id);
        $notes = $student->notes();
        return view('student.zone.notes', compact('notes'));
    }

    function getStudentNote(string $id)
    {
        $note = Note::findOrFail(decrypt($id));
        return view('student.zone.note', compact('note'));
    }
}
