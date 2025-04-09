<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['start_date' => 'datetime'];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge badge-danger'>Deleted</span>" : "<span class='badge badge-success'>Active</span>";
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function activeStudentCount()
    {
        return $this->belongsTo(StudentBatch::class, 'id', 'batch_id')->count();
    }
}
