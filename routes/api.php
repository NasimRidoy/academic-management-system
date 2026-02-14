<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; # App not app


Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('departments', DepartmentController::class);
        Route::apiResource('courses', CourseController::class);
        Route::apiResource('enrollments', EnrollmentController::class);

        Route::get('/students', [StudentController::class, 'index']);
        Route::post('/students', [StudentController::class, 'store']);
        Route::put('/students/{student}', [StudentController::class, 'update']);
        Route::delete('/students/{student}', [StudentController::class, 'destroy']);

        Route::get('/instructors', [InstructorController::class, 'index']);
        Route::post('/instructors', [InstructorController::class, 'store']);
        Route::put('/instructors/{instructor}', [InstructorController::class, 'update']);
        Route::delete('/instructors/{instructor}', [InstructorController::class, 'destroy']);
    });
    
    Route::get('/students/{student}', [StudentController::class, 'show']);
    Route::get('/instructors/{instructor}', [InstructorController::class, 'show']);
    
    
    Route::post('/logout', [AuthController::class, 'logout']);
});
