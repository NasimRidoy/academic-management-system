<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Instructor;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use SebastianBergmann\FileIterator\Facade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Cache::remember('students.index', 6, function () {
            Log::info('HIT Student Index DATABASE');
            return Student::with(['department', 'user'])->get();
        });

        return response()->json($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'nullable|string|size:11',
            'department_id' => 'required|exists:departments,id',
            'password'      => 'required|string'
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role'     => 'student'
        ]);

        $student = Student::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'phone'         => $validated['phone'],
            'department_id' => $validated['department_id'],
            'user_id'       => $user->id
        ]);

        Cache::forget('students.index');
        $student->load(['department', 'user']);
        return response()->json($student, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        
        $this->authorize('view', $student);

        $cacheKey = "students.show.$student->id";
        $data = Cache::remember($cacheKey, 6, function () use ($student) {
            Log::info('HIT Student Show DATABASE');
            return $student->load(['department', 'user', 'courses']);
        });

        return response()->json($data, 200);
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => "required|email|unique:users,email,{$student->user_id}",
            'phone'         => 'nullable|string|size:11',
            'department_id' => 'required|exists:departments,id'
        ]);

        $student->user->update([
            'name'  => $data['name'],
            'email' => $data['email']
        ]);

        $student->update([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'phone'         => $data['phone'],
            'department_id' => $data['department_id']
        ]);

        Cache::forget('students.index');
        Cache::forget("students.show.$student->id");
        $student->load(['department', 'user']);

        return response()->json($student, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        Cache::forget('students.index');
        Cache::forget("students.show.$student->id");
        return response()->json([
            'message' => 'Student deleted successfully'
        ], 200);
    }
}
