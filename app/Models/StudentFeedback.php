<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentFeedback extends Model
{
    use SoftDeletes;

    protected $table = 'student_feedback';

    protected $guarded = [];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'replied_by', 'id');
    }
}
