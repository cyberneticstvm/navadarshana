<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Course;
use App\Models\CourseSyllabus;
use App\Models\Module;
use App\Models\Student;
use App\Models\StudentBatch;
use App\Models\Subject;
use App\Models\SubjectModule;
use App\Models\Syllabus;
use App\Models\SyllabusSubject;
use App\Models\Topic;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    function getStudentDetails(String $studentId)
    {
        $student = Student::findOrFail($studentId);
        $activeBatches = Batch::whereIn('id', StudentBatch::where('student_id', $studentId)->pluck('batch_id'))->pluck('name')->implode('<br/>');
        if ($student->photo):
            $op = "<div class='header-media text-center'><img src='" . url($student->photo) . "' width='25%' /></div>";
        else:
            $op = "<div class='header-media text-center'><img src='" . asset('/assets/images/avatar.png') . "' width='25%' /></div>";
        endif;
        $op .= "<div class='row'><div class='col-md-12'><ul class='contacts'><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Admission Date: {$student->date_of_admission->format('d M, Y')}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Full Name: {$student->name}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Primary Contact: {$student->mobile}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Alternative Contact: {$student->alt_mobile}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Date of Birth: {$student->dob->format('d M, Y')}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Qualification: {$student->qualification}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Res. Category: {$student->reservation_category}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Address: {$student->address}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Enrollment Type: " . ucfirst($student->enrollment_type) . "</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Current Status: {$student->currentStatus()}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Deleted Status:  {$student->status()}</span></div></div></li></ul></div></div>";
        $op .= "<div class='row'><div class='col-md-12 mt-3 mb-3 ms-3'><h5>Active Batches</h5>{$activeBatches}</div></div>";
        echo $op;
    }

    function getStudentDetailsForBatch(String $batchId, String $action)
    {
        if ($action == 'add'):
            $students = Student::whereNotIn('id', StudentBatch::where('batch_id', $batchId)->pluck('student_id'))->latest()->get();
            $op = "<div class='table-responsive ms-2' style='width:100%'><table class='display table'><thead><tr><th>Id</th><th>Name</th><th>Select</th></tr><tbody>";
            foreach ($students as $key => $item):
                $op .= "<tr>";
                $op .= "<td>{$item->id}</td>";
                $op .= "<td>{$item->name}</td>";
                $op .= "<td><input type='checkbox' class='chkStudent' name='students[]' value='{$item->id}'></td>";
                $op .= "</tr>";
            endforeach;
            $op .= "<tr><input type='hidden' name='batch_id' value=" . encrypt($batchId) . "></tr>";
            $op .= "</tbody></tr></thead>";
            $op .= "</table></div>";
        else:
            $active = StudentBatch::withTrashed()->where('batch_id', $batchId)->get();
            $op = "<div class='table-responsive ms-2' style='width:100%'><table class='display table'><thead><tr><th>Id</th><th>Name</th><th>Action</th></tr><tbody>";
            foreach ($active as $key => $item):
                $op .= "<tr>";
                $op .= "<td>{$item->student->id}</td>";
                $op .= "<td>{$item->student->name}</td>";
                if ($item->deleted_at):
                    $op .= "<td><a href='/batch/student/restore/" . encrypt($item->id) . "' class='proceed'><i class='fa fa-recycle text-success' title='restore'></i></a></td>";
                else:
                    $op .= "<td class='text-center'><a href='/batch/student/remove/" . encrypt($item->id) . "' class='dlt'><i class='fa fa-trash text-danger' title='remove'></i></a></td>";
                endif;
                $op .= "</tr>";
            endforeach;
        endif;
        echo $op;
    }

    function getSyllabusForCourse(String $courseId, String $action)
    {
        $course = Course::findOrFail($courseId);
        if ($action == 'add'):
            $pending = Syllabus::whereNotIn('id', CourseSyllabus::where('course_id', $courseId)->pluck('syllabus_id'))->get();
            $op = "<input type='hidden' name='course_id' value=" . encrypt($courseId) . ">";
            $op .= "<h5 class='mt-3 ms-2'>" . $course->name . "</h5>";
            $op .= "<div class='mt-3 ms-2 mb-3'><select name='syllabus_id' class='form-control modal-select' required><option value=''>Select Syllabus</option>";
            foreach ($pending as $key => $syllabus):
                $op .= "<option value='" . $syllabus->id . "'>" . $syllabus->name . "</option>";
            endforeach;
            $op .= "</select></div>";
        else:
            $active = CourseSyllabus::withTrashed()->where('course_id', $courseId)->get();
            $op = "<h5 class='m-3'>Active Syllabuses - " . $course->name . "</h5>";
            $op .= "<div class='table-responsive ms-2' style='width:100%'><table class='display table'><thead><tr><th>SL No</th><th>Syllabus</th><th>Action</th></tr><tbody>";
            foreach ($active as $key => $item):
                $key = $key + 1;
                $op .= "<tr>";
                $op .= "<td>{$key}</td>";
                $op .= "<td>{$item->syllabus->name}</td>";
                if ($item->deleted_at):
                    $op .= "<td><a href='/course/syllabus/restore/" . encrypt($item->id) . "' class='proceed'><i class='fa fa-recycle text-success' title='restore'></i></a></td>";
                else:
                    $op .= "<td class='text-center'><a href='/course/syllabus/remove/" . encrypt($item->id) . "' class='dlt'><i class='fa fa-trash text-danger' title='remove'></i></a></td>";
                endif;
                $op .= "</tr>";
            endforeach;
            $op .= "</tbody></tr></thead>";
            $op .= "</table></div>";
        endif;
        echo $op;
    }

    function getSubjectsForSyllabus(String $syllabusId, String $action)
    {
        $syllabus = Syllabus::findOrFail($syllabusId);
        if ($action == 'add'):
            $pending = Subject::whereNotIn('id', SyllabusSubject::where('syllabus_id', $syllabusId)->pluck('subject_id'))->get();
            $op = "<input type='hidden' name='syllabus_id' value=" . encrypt($syllabusId) . ">";
            $op .= "<h5 class='mt-3 ms-2'>" . $syllabus->name . "</h5>";
            $op .= "<div class='mt-3 ms-2 mb-3'><select name='subject_id' class='form-control modal-select' required><option value=''>Select Subject</option>";
            foreach ($pending as $key => $subject):
                $op .= "<option value='" . $subject->id . "'>" . $subject->name . "</option>";
            endforeach;
            $op .= "</select></div>";
        else:
            $active = SyllabusSubject::withTrashed()->where('syllabus_id', $syllabusId)->get();
            $op = "<h5 class='m-3'>Active Subjects - " . $syllabus->name . "</h5>";
            $op .= "<div class='table-responsive ms-2' style='width:100%'><table class='display table'><thead><tr><th>SL No</th><th>Subject</th><th>Action</th></tr><tbody>";
            foreach ($active as $key => $item):
                $key = $key + 1;
                $op .= "<tr>";
                $op .= "<td>{$key}</td>";
                $op .= "<td>{$item->subject->name}</td>";
                if ($item->deleted_at):
                    $op .= "<td><a href='/syllabus/subject/restore/" . encrypt($item->id) . "' class='proceed'><i class='fa fa-recycle text-success' title='restore'></i></a></td>";
                else:
                    $op .= "<td class='text-center'><a href='/syllabus/subject/remove/" . encrypt($item->id) . "' class='dlt'><i class='fa fa-trash text-danger' title='remove'></i></a></td>";
                endif;
                $op .= "</tr>";
            endforeach;
            $op .= "</tbody></tr></thead>";
            $op .= "</table></div>";
        endif;
        echo $op;
    }

    function getModulesForSubject(String $subjectId, String $action)
    {
        $subject = Subject::findOrFail($subjectId);
        $active = Module::withTrashed()->where('subject_id', $subjectId)->get();
        $op = "<h5 class='m-3'>Active Modules - " . $subject->name . "</h5>";
        $op .= "<div class='table-responsive ms-2' style='width:100%'><table class='display table'><thead><tr><th>SL No</th><th>Module</th><th>Action</th></tr><tbody>";
        foreach ($active as $key => $item):
            $key = $key + 1;
            $op .= "<tr>";
            $op .= "<td>{$key}</td>";
            $op .= "<td>{$item->name}</td>";
            if ($item->deleted_at):
                $op .= "<td><a href='/subject/module/restore/" . encrypt($item->id) . "' class='proceed'><i class='fa fa-recycle text-success' title='restore'></i></a></td>";
            else:
                $op .= "<td class='text-center'><a href='/subject/module/remove/" . encrypt($item->id) . "' class='dlt'><i class='fa fa-trash text-danger' title='remove'></i></a></td>";
            endif;
            $op .= "</tr>";
        endforeach;
        $op .= "</tbody></tr></thead>";
        $op .= "</table></div>";
        echo $op;
    }

    function getTopicsForModule(String $moduleId, String $action)
    {
        $module = Module::findOrFail($moduleId);
        $active = Topic::withTrashed()->where('module_id', $moduleId)->get();
        $op = "<h5 class='m-3'>Active Topics - " . $module->name . "</h5>";
        $op .= "<div class='table-responsive ms-2' style='width:100%'><table class='display table'><thead><tr><th>SL No</th><th>Topic</th><th>Action</th></tr><tbody>";
        foreach ($active as $key => $item):
            $key = $key + 1;
            $op .= "<tr>";
            $op .= "<td>{$key}</td>";
            $op .= "<td>{$item->name}</td>";
            if ($item->deleted_at):
                $op .= "<td><a href='/module/topic/restore/" . encrypt($item->id) . "' class='proceed'><i class='fa fa-recycle text-success' title='restore'></i></a></td>";
            else:
                $op .= "<td class='text-center'><a href='/module/topic/remove/" . encrypt($item->id) . "' class='dlt'><i class='fa fa-trash text-danger' title='remove'></i></a></td>";
            endif;
            $op .= "</tr>";
        endforeach;
        $op .= "</tbody></tr></thead>";
        $op .= "</table></div>";
        echo $op;
    }
}
