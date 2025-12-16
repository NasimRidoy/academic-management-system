<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'code', 'department_id', 'instructor_id', 'credit'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    
    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
                    ->withPivot('gpa')
                    ->withTimestamps();
    }
}
