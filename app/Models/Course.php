<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'code', 'department_id', 'instructor_id', 'credit'];

    // Course belongs to a department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Course belongs to an instructor
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    // Course can have many students (many-to-many)
    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
                    ->withPivot('gpa')
                    ->withTimestamps();
    }
}
