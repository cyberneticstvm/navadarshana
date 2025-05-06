<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentBatch extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge badge-danger'>Deleted</span>" : "<span class='badge badge-success'>Active</span>";
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id', 'id');
    }

    public function attendance($student, $batch, $day, $month, $year)
    {
        return Attendance::where('student_id', $student)->where('batch_id', $batch)->whereDay('attendance_date', $day)->whereMonth('attendance_date', $month)->whereYear('attendance_date', $year)->selectRaw("IFNULL(CASE WHEN present = 1 THEN 'P' WHEN `leave` = 1 THEN 'L' ELSE 'A' END, 'NA') AS atype")->first();
    }
}
