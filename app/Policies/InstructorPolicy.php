<?php

namespace App\Policies;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InstructorPolicy
{
    public function view(User $user, Instructor $instructor): bool
    {
        return $user->role === 'admin'
            || ($user->role === 'instructor' && $instructor->user_id === $user->id);
    }
}
