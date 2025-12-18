<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{

    protected $fillable = ['student_id', 'course_id', 'gpa'];
    
    protected $attributes = [
        'gpa' => null, //default value
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
