<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Department extends Model
{
    use HasFactory;

    // protected $with = ['students', 'instructors', 'courses'];
    protected $fillable = ['name', 'code'];

    
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    
    public function instructors()
    {
        return $this->hasMany(Instructor::class);
    }

    
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

}
