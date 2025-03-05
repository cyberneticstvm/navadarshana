<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSchedule extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['date' => 'datetime', 'from_time' => 'datetime', 'to_time' => 'datetime'];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge badge-danger'>Deleted</span>" : "<span class='badge badge-success'>Active</span>";
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id', 'id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
    }

    public function syllabus()
    {
        return $this->belongsTo(Syllabus::class, 'syllabus_id', 'id');
    }
}
