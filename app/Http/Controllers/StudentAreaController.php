<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ClassSchedule;
use App\Models\CourseTopic;
use App\Models\Fee;
use App\Models\Note;
use App\Models\Student;
use App\Models\StudentBatch;
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
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('Student'), only: ['showProfile', 'getClassSchedules', 'getFeeDetails', 'exportFeeDetails']),
        ];
    }

    function showProfile()
    {
        $student = Student::with(['idType', 'branch'])
            ->findOrFail(Auth::user()->student_id);

        $photoUrl = null;
        if ($student->photo) {
            $photoUrl = str_starts_with($student->photo, 'http')
                ? $student->photo
                : gcsPublicUrl() . $student->photo;
        }

        return view('student.zone.profile', compact('student', 'photoUrl'));
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

        $fees = $this->feeQuery($student)
            ->paginate(20);

        $summary = Fee::where('student_id', $student->id)
            ->selectRaw('COUNT(*) AS payments, COALESCE(SUM(amount), 0) AS amount, COALESCE(SUM(discount), 0) AS discount, COALESCE(SUM(amount - COALESCE(discount, 0)), 0) AS paid')
            ->first();

        return view('student.zone.fee-details', compact('student', 'fees', 'summary'));
    }

    function exportFeeDetails()
    {
        $student = Student::with('branch')->findOrFail(Auth::user()->student_id);
        $fees = $this->feeQuery($student)->get();

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
