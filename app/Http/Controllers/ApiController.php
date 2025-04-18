<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ClassSchedule;
use App\Models\CourseSyllabus;
use App\Models\Module;
use App\Models\Note;
use App\Models\NoteAttachment;
use App\Models\Student;
use App\Models\StudentBatch;
use App\Models\StudentFeedback;
use App\Models\Syllabus;
use App\Models\Topic;
use App\Models\User;
use App\Models\VideoRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class ApiController extends Controller
{
    function authenicate(Request $request)
    {
        $credentials = array('email' => $request->json('email'), 'password' => $request->json('password'));
        $user = null;
        if (Auth::attempt($credentials)):
            $user = Auth::getProvider()->retrieveByCredentials($credentials);
        endif;
        if ($user):
            $batches = Batch::whereIn('id', StudentBatch::where('student_id', $user->student_id)->pluck('batch_id'))->orderBy('name')->get();
            if ($batches->isNotEmpty()):
                return response()->json([
                    'status' => true,
                    'user' => $user,
                    'message' => 'success',
                ], 200);
            else:
                return response()->json([
                    'status' => false,
                    'message' => 'Batches yet to be assigned',
                ], 401);
            endif;
        else:
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credentials',
            ], 401);
        endif;
    }

    function getStudent(Request $request)
    {
        $user_id = $request->json('user_id');
        $student = Student::where('id', User::find($user_id)->student_id)->first();
        if ($student):
            return response()->json([
                'status' => false,
                'student' => $student,
                'message' => 'No records found',
            ], 200);
        else:
            return response()->json([
                'status' => false,
                'student' => null,
                'message' => 'No records found',
            ], 404);
        endif;
    }

    function getStudentBatches(Request $request)
    {
        $student_id = $request->json('student_id');
        $batches = Batch::whereIn('id', StudentBatch::where('student_id', $student_id)->pluck('batch_id'))->orderBy('name')->get();
        if ($batches->isNotEmpty()):
            return response()->json([
                'status' => true,
                'batches' => $batches,
                'message' => 'success',
            ], 200);
        else:
            return response()->json([
                'status' => false,
                'batches' => null,
                'message' => 'No records found',
            ], 404);
        endif;
    }

    function getStudentSyllabuses(Request $request)
    {
        $batch_id = $request->json('batch_id');
        $batch = Batch::find($batch_id);
        $syllabuses = Syllabus::WhereIn('id', CourseSyllabus::where('course_id', $batch->course_id)->pluck('syllabus_id'))->orderBy('name')->get();
        if ($syllabuses->isNotEmpty()):
            return response()->json([
                'status' => true,
                'syllabuses' => $syllabuses,
                'message' => 'success',
            ], 200);
        else:
            return response()->json([
                'status' => false,
                'syllabuses' => null,
                'message' => 'No records found',
            ], 404);
        endif;
    }

    function getStudentModules(Request $request)
    {
        $modules = Module::where('syllabus_id', $request->json('syllabus_id'))->orderBy('name')->get();
        if ($modules->isNotEmpty()):
            return response()->json([
                'status' => true,
                'modules' => $modules,
                'message' => 'success',
            ], 200);
        else:
            return response()->json([
                'status' => false,
                'modules' => null,
                'message' => 'No records found',
            ], 404);
        endif;
    }

    function getStudentTopics(Request $request)
    {
        $topics = Topic::where('module_id', $request->json('module_id'))->orderBy('name')->get();
        if ($topics->isNotEmpty()):
            return response()->json([
                'status' => true,
                'topics' => $topics,
                'message' => 'success',
            ], 200);
        else:
            return response()->json([
                'status' => false,
                'topics' => null,
                'message' => 'No records found',
            ], 404);
        endif;
    }

    function getStudentNotes(Request $request)
    {
        $notes = Note::where('topic_id', $request->json('topic_id'))->latest()->get();
        if ($notes->isNotEmpty()):
            return response()->json([
                'status' => true,
                'notes' => $notes,
                'message' => 'success',
            ], 200);
        else:
            return response()->json([
                'status' => false,
                'notes' => null,
                'message' => 'No records found',
            ], 404);
        endif;
    }

    function getNote(Request $request)
    {
        $note = Note::where('id', $request->json('note_id'))->first();
        if ($note):
            return response()->json([
                'status' => true,
                'note' => $note,
                'message' => 'success',
            ], 200);
        else:
            return response()->json([
                'status' => false,
                'note' => null,
                'message' => 'No records found',
            ], 404);
        endif;
    }

    function getNoteAttachments(Request $request)
    {
        $attachments = NoteAttachment::where('note_id', $request->json('note_id'))->get();
        if ($attachments->isNotEmpty()):
            return response()->json([
                'status' => true,
                'attachments' => $attachments,
                'message' => 'success',
            ], 200);
        else:
            return response()->json([
                'status' => false,
                'attachments' => null,
                'message' => 'No records found',
            ], 404);
        endif;
    }

    function getClassSchedule(Request $request)
    {
        $batch_id = $request->json('batch_id');
        $schedules = ClassSchedule::leftJoin('batches as b', 'b.id', 'class_schedules.batch_id')->leftJoin('syllabi as s', 's.id', 'class_schedules.syllabus_id')->selectRaw("b.name AS bname, s.name AS sname, TIME_FORMAT(class_schedules.from_time, '%h:%i %p') AS ftime, TIME_FORMAT(class_schedules.to_time, '%h:%i %p') AS ttime")->whereDate('class_schedules.date', Carbon::now())->where('b.id', $batch_id)->orderBy('from_time')->get();
        if ($schedules->isNotEmpty()):
            return response()->json([
                'status' => true,
                'schedules' => $schedules,
                'message' => 'success',
            ], 200);
        else:
            return response()->json([
                'status' => false,
                'attachments' => null,
                'message' => 'No records found',
            ], 404);
        endif;
    }

    function getRecordedVideos(Request $request)
    {
        $syllabus_id = $request->json('syllabus_id');
        $videos = VideoRecord::where('syllabus_id', $syllabus_id)->get();
        if ($videos->isNotEmpty()):
            return response()->json([
                'status' => true,
                'videos' => $videos,
                'message' => 'success',
            ], 200);
        else:
            return response()->json([
                'status' => false,
                'videos' => null,
                'message' => 'No records found',
            ], 404);
        endif;
    }

    function updatePassword(Request $request)
    {
        $user_id = $request->json('user_id');
        $pwd = $request->json('password');
        User::where('id', $user_id)->update([
            'password' => Hash::make($pwd),
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully',
        ], 200);
    }

    function submitFeedback(Request $request)
    {
        $user_id = $request->json('user_id');
        $subject = $request->json('subject');
        $feedback = $request->json('feedback');
        $user = User::find($user_id);
        StudentFeedback::create([
            'student_id' => $user->student_id,
            'subject' => $subject,
            'feedback' => $feedback,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Feedback submitted successfully',
        ], 200);
    }
}
