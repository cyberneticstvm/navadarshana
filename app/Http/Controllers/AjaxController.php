<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Student;
use App\Models\StudentBatch;
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

    function getStudentDetailsForBatch(String $batchId)
    {
        $students = Student::whereNotIn('id', StudentBatch::where('batch_id', $batchId)->pluck('student_id'))->latest()->get();
        $op = "<div class='table-responsive' style='width:100%'><table class='display table'><thead><tr><th>Id</th><th>Name</th><th>Select</th></tr><tbody>";
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
        echo $op;
    }
}
