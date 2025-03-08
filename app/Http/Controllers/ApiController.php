<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ClassSchedule;
use App\Models\Module;
use App\Models\Note;
use App\Models\NoteAttachment;
use App\Models\Syllabus;
use App\Models\Topic;
use App\Models\VideoRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'success',
            ], 200);
        else:
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credentials',
            ], 401);
        endif;
    }

    function getStudentBatches()
    {
        $batches = Batch::orderBy('name')->get();
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
        $syllabuses = Syllabus::orderBy('name')->get();
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
        $schedules = ClassSchedule::selectRaw("'' AS bname, '' AS sname, TIME_FORMAT(from_time, '%h:%i %p') AS ftime, TIME_FORMAT(to_time, '%h:%i %p') AS ttime")->whereDate('date', Carbon::now())->orderBy('from_time')->get();
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
        $videos = VideoRecord::all();
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
}
