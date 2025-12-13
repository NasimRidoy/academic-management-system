<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; //for later creating factories
use Illuminate\Database\Eloquent\Model;


class Department extends Model
{
    use HasFactory;

    // protected $with = ['students', 'instructors', 'courses'];
    protected $fillable = ['name', 'code'];

    // One department has many students
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // One department has many instructors
    public function instructors()
    {
        return $this->hasMany(Instructor::class);
    }

    // One department has many courses
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

}
