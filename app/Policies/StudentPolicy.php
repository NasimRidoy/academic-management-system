<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentPolicy
{

    public function view(User $user, Student $student): bool
    {
        return $user->role === 'admin'
            || ($user->role === 'student' && $student->user_id === $user->id);
    }
}
