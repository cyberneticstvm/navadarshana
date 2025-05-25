<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['dob' => 'datetime', 'date_of_admission' => 'datetime'];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge badge-danger'>Deleted</span>" : "<span class='badge badge-success'>Active</span>";
    }

    public function currentStatus()
    {
        return ($this->current_status == 'inactive') ? "<span class='badge badge-danger'>Inactive</span>" : "<span class='badge badge-success'>Active</span>";
    }

    public function idType()
    {
        return $this->belongsTo(Extra::class, 'id_type', 'id');
    }

    public function activeBatches()
    {
        return $this->hasMany(StudentBatch::class, 'student_id', 'id');
    }

    public function batches()
    {
        return Batch::all();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function notes()
    {
        //return Note::whereIn('topic_id', CourseTopic::whereIn('course_id', Course::whereIn('id', Batch::whereIn('id', $this->activeBatches()->pluck('batch_id'))->pluck('course_id')))->pluck('topic_id'));
        return CourseTopic::whereIn('topic_id', Course::whereIn('id', Batch::whereIn('id', $this->activeBatches()->pluck('batch_id'))->pluck('course_id'))->pluck('topic_id'))->get();
    }
}
