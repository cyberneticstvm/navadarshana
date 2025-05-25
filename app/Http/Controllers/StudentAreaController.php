<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\CourseTopic;
use App\Models\Note;
use App\Models\Student;
use App\Models\StudentBatch;
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
        ];
    }

    function getStudentNotes()
    {
        /*$notes = Note::whereIn('topic_id', CourseTopic::whereIn('course_id', Batch::whereIn('id', StudentBatch::where('student_id', Auth::user()->student_id)->pluck('batch_id'))->pluck('course_id'))->pluck('topic_id'))->get();*/
        $student = Student::findOrFail(Auth::user()->student_id);
        $notes = $student->notes();
        dd($notes);
        die;
        return view('student.zone.notes', compact('notes'));
    }

    function getStudentNote(string $id)
    {
        $note = Note::findOrFail(decrypt($id));
        return view('student.zone.note', compact('note'));
    }
}
