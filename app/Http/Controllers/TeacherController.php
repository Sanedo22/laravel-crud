<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TeacherController extends Controller
{
    // Index view
    public function index()
    {
        return view('admin.teachers.index');
    }

    // Ajax Data
    public function data()
    {
        $teachers = Teacher::select(['id', 'name', 'email', 'subject']);

        return DataTables::of($teachers)
            ->addIndexColumn() // DT_RowIndex (serial number)
            ->addColumn('action', function ($row) {
                $editUrl = route('teachers-edit', $row->id);

                return '
                    <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    //Store data
    public function store(Request $request)
    {
        $data = $this->validateTeacher($request);

        Teacher::create($data);

        return redirect()->route('teachers-index')
            ->with('success', 'Teacher added successfully');
    }

    // Edit view
    public function edit(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    // Update
    public function update(Request $request, string $id)
    {
        $teacher = Teacher::findOrFail($id);

        $data = $this->validateTeacher($request, $teacher->id);

        $teacher->update($data);

        return redirect()->route('teachers-index')
            ->with('success', 'Teacher updated successfully');
    }

    // Delete with AJAX
    public function destroy($id)
    {
        Teacher::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // Reusable Validations
    private function validateTeacher(Request $request, $id = null)
    {
        return $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:teachers,email,' . $id,
            'subject' => 'required|string|max:255',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'subject.required' => 'The subject field is required.',
        ]);
    }
}
