<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.students.index');
    }

    public function data()
    {
        $students = Student::select(['id', 'name', 'email', 'age']);

        return DataTables::of($students)
            ->addIndexColumn() // DT_RowIndex (serial number)
            ->addColumn('action', function ($row) {
                $editUrl = route('students-edit', $row->id);

                return '
                    <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $data = $this->validateStudent($request);

        Student::create($data);

        return redirect()->route('students-index')
            ->with('success', 'Student added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $students = Student::findOrFail($id);
        return view('admin.students.edit', compact('students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $students = Student::findOrFail($id);

        $data = $this->validateStudent($request, $students->id);

        $students->update($data);

        return redirect()->route('students-index')
            ->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    private function validateStudent(Request $request, $id = null)
    {
        return $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:students,email,' . $id,
            'age' => 'required|integer|min:1',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'age.required' => 'The Age field is required.',
        ]);
    }
}
