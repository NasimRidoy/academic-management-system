<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Instructor::with(['department', 'user', 'courses'])->get(),
        200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   //correct code before authentication
        // $data = $request->validate([
        //     'name'          => 'required|string|max:255',
        //     'email'         => 'required|email|max:255|unique:instructors,email',
        //     'phone'         => 'nullable|digits:11',
        //     'department_id' => 'required|exists:departments,id'
        // ]);
        // $instructor  =  Instructor::create($data);
        // return response()->json($instructor->load(['department', 'courses']), 201);

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
            'role'     => 'instructor',
        ]);

        $instructor = Instructor::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'phone'         => $validated['phone'],
            'department_id' => $validated['department_id'],
            'user_id'       => $user->id
        ]);
        $instructor->load(['department', 'user', 'courses']);
        return response()->json($instructor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Instructor $instructor)
    {
        $this->authorize('view', $instructor);

        $instructor->load(['department', 'user', 'courses']);
        return response()->json($instructor, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instructor $instructor)
    {
        // $data = $request->validate([
        //     'name'          => 'required|string|max:255',
        //     // 'email'         => "required|email|max:255|unique:instructors,email,{$instructor->id}", cannot change email, admin can delete the email and than create new email
        //     'phone'         => 'nullable|string|size:11',
        //     'department_id' => 'required|exists:departments,id',
        // ]);
        // $instructor->update($data);
        // return response()->json($instructor->load(['department', 'courses']), 200);

        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => "required|email|unique:users,email,{$instructor->user_id}",
            'phone'         => 'nullable|string|size:11',
            'department_id' => 'required|exists:departments,id'
        ]);

        // Update related user account
        $instructor->user->update([
            'name'  => $data['name'],
            'email' => $data['email']
        ]);

        // Update instructor entry
        $instructor->update([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'phone'         => $data['phone'],
            'department_id' => $data['department_id']
        ]);

        $instructor->load(['department', 'user', 'courses']);

        return response()->json($instructor, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructor)
    {
        //correct code before authenticate
        // $instructor->delete();
        // return response()->json(['message' => 'Deleted'], 200);

        $instructor->user->delete();

        return response()->json([
            'message' => 'Instructor deleted successfully'
        ], 200);
    }
}
