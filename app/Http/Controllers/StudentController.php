<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;


class StudentController extends Controller
{
    // Load the main list view
    public function index()
    {
        return view('admin.students.index');
    }

    // AJAX response for student list datatable
    public function data()
    {
        $students = Student::select(['id', 'name', 'email', 'age', 'image']);

        return DataTables::of($students)
            ->addIndexColumn() // DT_RowIndex (serial number)
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    $imageUrl = asset('storage/' . $row->image);
                    return '<img src="' . $imageUrl . '" width="50" class="img-thumbnail" alt="Student Image">';
                }
                return '<span class="text-muted">No Image</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('students-edit', $row->id);

                return '
                    <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                ';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }
    // Create new student record with image upload
    public function store(Request $request)
    {
        $data = $this->validateStudent($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('students', 'public');
        }

        Student::create($data);

        return redirect()->route('students-index')
            ->with('success', 'Student added successfully');
    }

    // Show individual record (not implemented)
    public function show(string $id)
    {
        //
    }

    // Fetch data for the edit form
    public function edit(string $id)
    {
        $students = Student::findOrFail($id);
        return view('admin.students.edit', compact('students'));
    }

    // Update record and handle image swap
    public function update(Request $request, string $id)
    {
        $students = Student::findOrFail($id);

        $data = $this->validateStudent($request, $students->id);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($students->image && Storage::disk('public')->exists($students->image)) {
                Storage::disk('public')->delete($students->image);
            }
            $data['image'] = $request->file('image')->store('students', 'public');
        }

        $students->update($data);

        return redirect()->route('students-index')
            ->with('success', 'Student updated successfully');
    }

    // Soft delete record via AJAX
    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // Load the trash view
    public function trashed()
    {
        return view('admin.students.trashed');
    }

    // AJAX response for trashed records only
    public function trashedData()
    {
        $students = Student::onlyTrashed()->select(['id', 'name', 'email', 'age', 'image']);

        return DataTables::of($students)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    $imageUrl = asset('storage/' . $row->image);
                    return '<img src="' . $imageUrl . '" width="50" class="img-thumbnail" alt="Student Image">';
                }
                return '<span class="text-muted">No Image</span>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-success restore-btn" data-id="'.$row->id.'">Restore</button>
                    <button class="btn btn-sm btn-danger force-delete-btn" data-id="'.$row->id.'">Delete Permanently</button>
                ';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    // Restore a soft-deleted record
    public function restore($id)
    {
        Student::withTrashed()->findOrFail($id)->restore();
        return response()->json(['success' => true]);
    }

    // Permanent delete from DB and storage
    public function forceDelete($id)
    {
        $student = Student::withTrashed()->findOrFail($id);

        if ($student->image && Storage::disk('public')->exists($student->image)) {
            Storage::disk('public')->delete($student->image);
        }

        $student->forceDelete();
        return response()->json(['success' => true]);
    }

    // Reusable validation logic
    private function validateStudent(Request $request, $id = null)
    {
        return $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:students,email,' . $id,
            'age' => 'required|integer|min:1',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'age.required' => 'The Age field is required.',
            'image.image'   => 'The file must be an image.',
            'image.mimes'   => 'The image must be a type of jpeg, png, jpg, gif.',
            'image.max'     => 'The image size must not exceed 2MB.',
        ]);
    }
}
