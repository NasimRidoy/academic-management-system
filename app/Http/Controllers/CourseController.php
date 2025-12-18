<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with(['department', 'instructor'])->get();
        return response()->json($courses, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
            'department_id' => 'required|exists:departments,id',
            'instructor_id' => 'nullable|exists:instructors,id',
            'credit' => 'required|numeric'
        ]);
        $course = Course::create($data);
        $course->load(['department', 'instructor', 'students']);

        return response()->json($course, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load(['department', 'instructor', 'students']);
        return response()->json($course, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
            'department_id' => 'required|exists:departments,id',
            'instructor_id' => 'required|exists:instructors,id',
            'credit' => 'required|numeric'
        ]);

        $course->update($data);
        $course->load(['department', 'instructor', 'students']);

        return response()->json($course, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(['message' => 'Course Successfully Deleted'], 200);
    }
}
