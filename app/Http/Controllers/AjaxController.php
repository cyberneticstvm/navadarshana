<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\CourseTopic;
use App\Models\Fee;
use App\Models\Module;
use App\Models\Student;
use App\Models\StudentBatch;
use App\Models\SyllabiModule;
use App\Models\Syllabus;
use App\Models\Topic;
use App\Models\TopicComplete;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
                    //$items = CourseTopic::leftJoin('topics as t', 't.id', 'course_topics.topic_id')->where('course_id', $batch->course_id)->select('t.name', 't.id')->get();
                    $items = CourseTopic::where('course_id', $batch->course_id)->leftJoin('topics as t', 'course_topics.topic_id', 't.id')->leftJoin('modules as m', 'm.id', 't.module_id')->leftjoin('syllabi as s', 's.id', 'm.syllabus_id')->select('s.name', 's.id')->distinct()->get();
                endif;
                break;
        endswitch;
        return response()->json([
            'items' => $items,
        ]);
    }

    function getStudentDetails(String $studentId)
    {
        $student = Student::where('id', $studentId)->first();
        $op = "";
        if ($student):
            $fees = Fee::where('student_id', $student->id)->get();
            $activeBatches = Batch::whereIn('id', StudentBatch::where('student_id', $studentId)->pluck('batch_id'))->pluck('name')->implode('<br/>');
            if ($student->photo):
                $op .= "<div class='header-media text-center'><img src='" . gcsPublicUrl() . $student->photo . "' width='25%' /></div>";
            else:
                $op .= "<div class='header-media text-center'><img src='" . asset('/assets/images/avatar.png') . "' width='25%' /></div>";
            endif;
            $op .= "<div class='row'><div class='col-md-12'><ul class='contacts'><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Admission Date: {$student->date_of_admission->format('d M, Y')}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Student ID: <strong>{$student->id}</strong></span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Full Name: {$student->name}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Gender: " . ucfirst($student->gender ?? 'Na') . "</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Primary Contact: {$student->mobile}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Alternative Contact: {$student->alt_mobile}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Date of Birth: {$student->dob->format('d M, Y')}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Qualification: {$student->qualification}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Res. Category: {$student->reservation_category}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Address: {$student->address}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Enrollment Type: " . ucfirst($student->enrollment_type) . "</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>ID Type: " . $student->idType?->value . "</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>ID Number: " . $student->id_number . "</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Current Status: {$student->currentStatus()}</span></div></div></li><li class='active'><div class='d-flex bd-highlight'><div class=''><span class='text-dark'>Deleted Status:  {$student->status()}</span></div></div></li></ul></div></div>";
            $op .= "<div class='row'><div class='col-md-12 mt-3 mb-3 ms-3'><h5 class='text-info'>Active Batches</h5>{$activeBatches}</div></div>";
            $op .= "<div class='row'><div class='col-md-12 ms-3'><h5 class='text-info'>Fee Details</h5></div></div>";
            $op .= "<div class='table-responsive ms-2' style='width:100%'><table class='display table'><thead><tr><th>Batch</th><th>Category</th><th>Amount</th><th>Date</th><th>MonthYear</th></tr></thead><tbody>";
            foreach ($fees as $key => $fee):
                $feemy = ($fee?->category != 'admission') ? $fee?->getMonth?->name . '.' . $fee?->year : $fee?->payment_date?->format('d.M.Y');
                switch ($fee->category):
                    case "monthly":
                        $cat = 'Batch';
                        break;
                    case "admission":
                        $cat = 'Admission';
                        break;
                    default:
                        $cat = $fee->remarks;
                endswitch;
                $op .= "<tr>";
                $op .= "<td>{$fee->batch->name}</td>";
                $op .= "<td>{$cat}</td>";
                $op .= "<td>" . number_format($fee?->amount - $fee?->discount, 2) . "</td>";
                $op .= "<td>" . $fee?->payment_date?->format('d.M.Y') . "</td>";
                $op .= "<td>{$feemy}</td>";
                $op .= "</tr>";
            endforeach;
            $op .= "</tbody>";
            $op .= "</table></div>";
        else:
            $op .= "<div class='row'><div class='col-md-12 mt-3 mb-3 ms-3 text-danger'>Requested record deleted or not found</div></div>";
        endif;
        echo $op;
    }

    function getStudentDetailsForBatch(String $batchId, String $action)
    {
        if ($action == 'add'):
            $students = Student::whereNotIn('id', StudentBatch::where('batch_id', $batchId)->pluck('student_id'))->where('branch_id', Session::get('branch'))->latest()->get();
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

    function getTopicDetailsForCourse(String $courseId, String $action)
    {
        if ($action == 'add'):
            $syllabuses = Syllabus::orderBy('name')->get();
            $op = "";
            $op .= "<div class='m-3 accordion accordion-no-gutter accordion-bordered accordion-header-bg' id='accordion-four'>";
            foreach ($syllabuses as $key => $syllabus):
                $show = ($key == 0) ? 'show' : '';
                $op .= "<div class='accordion-item'>";
                $op .= "<h2 class='accordion-header accordion-header-info'>";
                $op .= "<button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#bordered-no-gutter-collapse-{$syllabus->id}'>{$syllabus->name}</button>";
                $op .= "</h2>";
                $op .= "<div id='bordered-no-gutter-collapse-{$syllabus->id}' class='accordion-collapse collapse {$show}' data-bs-parent='#accordion-four'>";
                $op .= "<div class='accordion-body'>";
                $op .= "<div class='table-responsive'><table class='display table' style='width:100%'><tbody>";
                $op .= "<div class='m-1 accordion accordion-no-gutter accordion-bordered accordion-header-bg' id='accordion-five'>";
                foreach ($syllabus->modules as $key1 => $module):
                    $show1 = ($key1 == 0) ? 'show' : '';
                    $op .= "<div class='accordion-item'>";
                    $op .= "<h2 class='accordion-header accordion-header-primary'>";
                    $op .= "<button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#bordered-no-gutter-collapse-{$syllabus->id}-{$module->id}'>{$module->name}</button>";
                    $op .= "</h2>";
                    $op .= "<div id='bordered-no-gutter-collapse-{$syllabus->id}-{$module->id}' class='accordion-collapse collapse {$show1}' data-bs-parent='#accordion-five'>";
                    $op .= "<div class='accordion-body'>";
                    foreach ($module->topics->whereNotIn('id', CourseTopic::where('course_id', $courseId)->pluck('topic_id')) as $key2 => $topic):
                        $op .= "<div><input type='checkbox' class='chkTopic' name='topics[]' value='{$topic->id}'> {$topic->name}</div>";
                    endforeach;
                    $op .= "</div></div></div>";
                endforeach;
                $op .= "</div>";
                $op .= "</tbody></table></div>";
                $op .= "</div></div></div>";
            endforeach;
            $op .= "<input type='hidden' name='course_id' value=" . encrypt($courseId) . ">";
            $op .= "</div>";
        else:
            $modules = Module::whereIn('id', Topic::whereIn('id', CourseTopic::withTrashed()->where('course_id', $courseId)->pluck('topic_id'))->pluck('module_id'))->get();
            $op = "";
            $op .= "<div class='m-3 accordion accordion-no-gutter accordion-bordered' id='accordion-four'>";
            foreach ($modules as $key => $module):
                $active = CourseTopic::withTrashed()->leftJoin('topics as t', 't.id', 'course_topics.topic_id')->where('course_id', $courseId)->selectRaw("course_topics.id, course_topics.topic_id, course_topics.deleted_at, t.module_id")->get();
                $op .= "<div class='accordion-item'>";
                $op .= "<h2 class='accordion-header'>";
                $op .= "<button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#bordered-no-gutter-collapse-{$module->id}'>{$module->name}</button>";
                $op .= "</h2>";
                $op .= "<div id='bordered-no-gutter-collapse-{$module->id}' class='accordion-collapse collapse' data-bs-parent='#accordion-four'>";
                $op .= "<div class='accordion-body'>";
                $op .= "<div class='table-responsive ms-2' style='width:100%'><table class='display table'><thead><tr><th>Id</th><th>Name</th><th>Action</th></tr><tbody>";
                foreach ($active as $key => $item):
                    if ($module->id == $item->module_id):
                        $op .= "<tr>";
                        $op .= "<td>{$item->id}</td>";
                        $op .= "<td>{$item->topic?->name}</td>";
                        if ($item->deleted_at):
                            $op .= "<td><a href='/course/topic/restore/" . encrypt($item->id) . "' class='proceed'><i class='fa fa-recycle text-success' title='restore'></i></a></td>";
                        else:
                            $op .= "<td class='text-center'><a href='/course/topic/remove/" . encrypt($item->id) . "' class='dlt'><i class='fa fa-trash text-danger' title='remove'></i></a></td>";
                        endif;
                        $op .= "</tr>";
                    endif;
                endforeach;
                $op .= "</tbody></table></div>";
                $op .= "</div></div></div>";
            endforeach;
            $op .= "</div>";
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
        $batch = Batch::findOrFail($batchId);
        $op = "";
        $op .= "<div class='m-3 accordion accordion-no-gutter accordion-bordered' id='accordion-four'>";
        foreach ($modules as $key => $module):
            $m = $module->topics->whereIn('id', CourseTopic::where('course_id', $batch->course_id)->pluck('topic_id'));
            if ($m->isNotEmpty()):
                $show = ($key == 0) ? 'show' : '';
                $op .= "<div class='accordion-item'>";
                $op .= "<h2 class='accordion-header'>";
                $op .= "<button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#bordered-no-gutter-collapse-{$module->id}'>{$module->name}</button>";
                $op .= "</h2>";
                $op .= "<div id='bordered-no-gutter-collapse-{$module->id}' class='accordion-collapse collapse {$show}' data-bs-parent='#accordion-four'>";
                $op .= "<div class='accordion-body'>";
                $op .= "<div class='table-responsive'><table class='display table' style='width:100%'><tbody>";
                foreach ($module->topics->whereIn('id', CourseTopic::where('course_id', $batch->course_id)->pluck('topic_id')) as $key1 => $topic):
                    $vals = TopicComplete::where('batch_id', $batchId)->where('syllabus_id', $syllabusId)->where('module_id', $module->id)->where('topic_id', $topic->id);
                    $checked = (in_array($topic->id, $vals->pluck('topic_id')->toArray())) ? 'checked' : '';
                    $op .= "<tr>";
                    $op .= "<td>{$topic->name}</td>";
                    $op .= "<td><input type='checkbox' class='form-check-input chkModuleTopic' name='topics[]' id='customCheckBox{$topic->id}' value='{$topic->id}' {$checked} data-batch='{$batchId}' data-syllabus='{$syllabusId}' data-module='{$module->id}' data-topic='{$topic->id}' data-faculty='{$facultyId}'></td>";
                    $op .= "</tr>";
                endforeach;
                $op .= "</tbody></table></div>";
                $op .= "</div></div></div>";
            endif;
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

    function getNoteDetails(string $id)
    {
        $topic = Topic::where('id', $id)->first();
        $op = "<div class='table-responsive ms-2' style='width:100%'><table class='display table'><thead><tr><th>Title</th></tr><tbody>";
        if ($topic):
            foreach ($topic->notes as $key => $item):
                $op .= "<tr>";
                $op .= "<td class='text-start'>{$item->title}</td>";
                $op .= "</tr>";
            endforeach;
        else:
            $op .= "<tr><td>No records found</td></tr>";
        endif;
        $op .= "</tbody></tr></thead>";
        $op .= "</table></div>";
        echo $op;
    }

    function getStudentFeeDetails(string $id)
    {
        $fee = Fee::where('id', $id)->first();
        $op = "";
        $op .= "<div class='container'><div class='row mt-3'><div class='col-md-12'><input type='hidden' name='fee_id' value='{$fee->id}' /><input type='text' class='form-control' name='name' value='" . $fee->student->name . "' placeholder='Student Name' required /></div><div class='col-md-12 mt-3'><input type='email' class='form-control' name='email' value='" . $fee->student->email . "' placeholder='Student Email' required /></div><div class='col-md-12 mt-3'><textarea class='form-control' name='body' placeholder='Email Body' rows='5' required></textarea></div><div class='col-md-12 mt-3 text-end'><button type='submit' class='btn btn-submit btn-success'>Send Email</button></div></div></div>";
        echo $op;
    }

    function validateFee(Request $request)
    {
        $batch = Batch::findOrFail($request->batch_id);
        if ($request->fid == 0):
            $fee = Fee::where('student_id', decrypt($request->student_id))->where('batch_id', $request->batch_id)->where('month', $request->month)->where('year', $request->year)->first();
            if ($fee?->category == 'monthly' && $request->category == 'monthly' && $fee->type == 'full'):
                return response()->json([
                    "type" => "warning",
                    "message" => "Fee already recorded!",
                ]);
            endif;
        endif;
        if ($request->amount > $batch->admission_fee && $request->category == 'admission'):
            return response()->json([
                "type" => "warning",
                "message" => "Fee amount should not be greater than " . $batch->admission_fee
            ]);
        endif;
        if ($request->amount > $batch->monthly_fee && $request->category == 'monthly'):
            return response()->json([
                "type" => "warning",
                "message" => "Fee amount should not be greater than " . $batch->monthly_fee
            ]);
        endif;
        return response()->json([
            "type" => "success",
            "message" => "success",
        ]);
    }

    function feePending(Request $request)
    {
        $fee = getFeePending($request);
        return response()->json([
            "fee" => number_format($fee->sum('fees'), 2),
        ]);
    }
}
