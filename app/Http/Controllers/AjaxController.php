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
use App\Models\SyllabiModule;
use App\Models\Syllabus;
use App\Models\SyllabusSubject;
use App\Models\Topic;
use App\Models\TopicComplete;
use App\Models\TopicCompleted;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AjaxController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('update-batch-topic-complete'), only: ['updateBatchTopicStatus']),
        ];
    }

    function getDropDown(Request $request)
    {
        $items = collect();
        switch ($request->give):
            case 'syllabus';
                if ($request->take == 'module')
                    $items = Module::where('syllabus_id', $request->typeId)->get();
                break;
            case 'module';
                if ($request->take == 'topic')
                    $items = Topic::where('module_id', $request->typeId)->get();
                break;
            case 'batch';
                if ($request->take == 'syllabus'):
                    $batch = Batch::find($request->typeId);
                    $items = CourseSyllabus::leftJoin('syllabi as s', 's.id', 'course_syllabi.syllabus_id')->where('course_id', $batch->course_id)->select('s.name', 's.id')->get();
                endif;
                break;
        endswitch;
        return response()->json([
            'items' => $items,
        ]);
    }

    function getStudentDetails(String $studentId)
    {
        $student = Student::findOrFail($studentId);
        $activeBatches = Batch::whereIn('id', StudentBatch::where('student_id', $studentId)->pluck('batch_id'))->pluck('name')->implode('<br/>');
        if ($student->photo):
            $op = "<div class='header-media text-center'><img src='" . gcsPublicUrl() . $student->photo . "' width='25%' /></div>";
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

    function getSyllabusDetailsForCourse(String $courseId, String $action)
    {
        if ($action == 'add'):
            $students = Syllabus::whereNotIn('id', CourseSyllabus::where('course_id', $courseId)->pluck('syllabus_id'))->latest()->get();
            $op = "<div class='table-responsive ms-2' style='width:100%'><table class='display table'><thead><tr><th>Id</th><th>Name</th><th>Select</th></tr><tbody>";
            foreach ($students as $key => $item):
                $op .= "<tr>";
                $op .= "<td>{$item->id}</td>";
                $op .= "<td>{$item->name}</td>";
                $op .= "<td><input type='checkbox' class='chkSyllabus' name='syllabuses[]' value='{$item->id}'></td>";
                $op .= "</tr>";
            endforeach;
            $op .= "<tr><input type='hidden' name='course_id' value=" . encrypt($courseId) . "></tr>";
            $op .= "</tbody></tr></thead>";
            $op .= "</table></div>";
        else:
            $active = CourseSyllabus::withTrashed()->where('course_id', $courseId)->get();
            $op = "<div class='table-responsive ms-2' style='width:100%'><table class='display table'><thead><tr><th>Id</th><th>Name</th><th>Action</th></tr><tbody>";
            foreach ($active as $key => $item):
                $op .= "<tr>";
                $op .= "<td>{$item->id}</td>";
                $op .= "<td>{$item->syllabus->name}</td>";
                if ($item->deleted_at):
                    $op .= "<td><a href='/course/syllabus/restore/" . encrypt($item->id) . "' class='proceed'><i class='fa fa-recycle text-success' title='restore'></i></a></td>";
                else:
                    $op .= "<td class='text-center'><a href='/course/syllabus/remove/" . encrypt($item->id) . "' class='dlt'><i class='fa fa-trash text-danger' title='remove'></i></a></td>";
                endif;
                $op .= "</tr>";
            endforeach;
        endif;
        echo $op;
    }

    function getModulesForSyllabus(String $syllabusId, String $action)
    {
        $syllabus = Syllabus::findOrFail($syllabusId);
        if ($action == 'add'):
            $modules = Module::whereNotIn('id', SyllabiModule::where('syllabus_id', $syllabus->id)->pluck('module_id'))->latest()->get();
            $op = "<div class='table-responsive ms-2' style='width:100%'><table class='display table'><thead><tr><th>Id</th><th>Name</th><th>Select</th></tr><tbody>";
            foreach ($modules as $key => $item):
                $op .= "<tr>";
                $op .= "<td>{$item->id}</td>";
                $op .= "<td>{$item->name}</td>";
                $op .= "<td><input type='checkbox' class='chkModule' name='modules[]' value='{$item->id}'></td>";
                $op .= "</tr>";
            endforeach;
            $op .= "<tr><input type='hidden' name='syllabus_id' value=" . encrypt($syllabus->id) . "></tr>";
            $op .= "</tbody></tr></thead>";
            $op .= "</table></div>";
        else:
            $active = SyllabiModule::withTrashed()->where('syllabus_id', $syllabusId)->get();
            $op = "<h5 class='m-3'>Active Modules - " . $syllabus->name . "</h5>";
            $op .= "<div class='table-responsive ms-2' style='width:100%'><table class='display table'><thead><tr><th>SL No</th><th>Module</th><th>Action</th></tr><tbody>";
            foreach ($active as $key => $item):
                $key = $key + 1;
                $op .= "<tr>";
                $op .= "<td>{$key}</td>";
                $op .= "<td>{$item->name}</td>";
                if ($item->deleted_at):
                    $op .= "<td><a href='/syllabus/module/restore/" . encrypt($item->id) . "' class='proceed'><i class='fa fa-recycle text-success' title='restore'></i></a></td>";
                else:
                    $op .= "<td class='text-center'><a href='/syllabus/module/remove/" . encrypt($item->id) . "' class='dlt'><i class='fa fa-trash text-danger' title='remove'></i></a></td>";
                endif;
                $op .= "</tr>";
            endforeach;
            $op .= "</tbody></tr></thead>";
            $op .= "</table></div>";
        endif;
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

    function getModuleTopicsForSyllabus(String $syllabusId, String $batchId, String $facultyId)
    {
        $modules = Module::where('syllabus_id', $syllabusId)->get();
        $op = "";
        $op .= "<div class='m-3 accordion accordion-no-gutter accordion-bordered' id='accordion-four'>";
        foreach ($modules as $key => $module):
            $show = ($key == 0) ? 'show' : '';
            $op .= "<div class='accordion-item'>";
            $op .= "<h2 class='accordion-header'>";
            $op .= "<button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#bordered-no-gutter-collapse-{$module->id}'>{$module->name}</button>";
            $op .= "</h2>";
            $op .= "<div id='bordered-no-gutter-collapse-{$module->id}' class='accordion-collapse collapse {$show}' data-bs-parent='#accordion-four'>";
            $op .= "<div class='accordion-body'>";
            $op .= "<div class='table-responsive'><table class='display table' style='width:100%'><tbody>";
            foreach ($module->topics as $key1 => $topic):
                $vals = TopicComplete::where('batch_id', $batchId)->where('syllabus_id', $syllabusId)->where('module_id', $module->id)->where('topic_id', $topic->id);
                $checked = (in_array($topic->id, $vals->pluck('topic_id')->toArray())) ? 'checked' : '';
                $op .= "<tr>";
                $op .= "<td>{$topic->name}</td>";
                $op .= "<td><input type='checkbox' class='form-check-input chkModuleTopic' name='topics[]' id='customCheckBox{$topic->id}' value='{$topic->id}' {$checked} data-batch='{$batchId}' data-syllabus='{$syllabusId}' data-module='{$module->id}' data-topic='{$topic->id}' data-faculty='{$facultyId}'></td>";
                $op .= "</tr>";
            endforeach;
            $op .= "</tbody></table></div>";
            $op .= "</div></div></div>";
        endforeach;
        $op .= "</div>";
        echo $op;
    }

    function updateBatchTopicStatus(Request $request)
    {
        if ($request->user()->can('update-batch-topic-complete')):
            if ($request->isChecked):
                TopicComplete::create([
                    'batch_id' => $request->batch,
                    'syllabus_id' => $request->syllabus,
                    'module_id' => $request->module,
                    'topic_id' => $request->topic,
                    'faculty_id' => $request->faculty,
                ]);
            else:
                TopicComplete::where('batch_id', $request->batch)->where('syllabus_id', $request->syllabus)->where('module_id', $request->module)->where('topic_id', $request->topic)->delete();
            endif;
            return response()->json([
                "success" => "Topic updated successfully",
            ]);
        else:
            return response()->json([
                "error" => "User does not have right permission",
            ]);
        endif;
    }
}
