<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'department_id', 'user_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
                    ->withPivot('gpa')
                    ->withTimestamps();
    }
}
