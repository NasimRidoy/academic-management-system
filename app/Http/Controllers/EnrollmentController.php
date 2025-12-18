<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollment = Enrollment::with(['student', 'course'])->get();
        return response()->json($enrollment, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id'
        ]);

        $enrollment = Enrollment::firstOrCreate(
            ['student_id' => $data['student_id'], 'course_id' => $data['course_id']],
            $data
        );

        return response()->json($enrollment->load(['student', 'course']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        return response()->json($enrollment->load(['student', 'course']), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $data = $request->validate([
            'gpa' => 'nullable|numeric|min:0|max:4'
        ]);

        $enrollment->update($data);

        return response()->json($enrollment->load(['student', 'course']), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return response()->json(['message' => 'Enrollment deleted'], 200);
    }
}
