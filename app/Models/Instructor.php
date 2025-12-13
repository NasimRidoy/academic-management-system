<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    

    protected $fillable = ['name', 'email', 'phone', 'department_id', 'user_id'];

   
    public function department()                   
    {
        return $this->belongsTo(Department::class);
    }

    
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
