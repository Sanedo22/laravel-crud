<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    // Sidebar link: All Teachers
    public function index()
    {
        return view('admin.teachers.index');
    }

    // JSON source for teachers table
    public function data()
    {
        $teachers = Teacher::select(['id', 'name', 'email', 'subject', 'image']);

        return DataTables::of($teachers)
            ->addIndexColumn() // DT_RowIndex (serial number)
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    $imageUrl = asset('storage/' . $row->image);
                    return '<img src="' . $imageUrl . '" width="50" class="img-thumbnail" alt="Teacher Image">';
                }
                return '<span class="text-muted">No Image</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('teachers-edit', $row->id);

                return '
                    <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                ';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    // Handle form submission and storage
    public function store(Request $request)
    {
        $data = $this->validateTeacher($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('teachers', 'public');
        }

        Teacher::create($data);

        return redirect()->route('teachers-index')
            ->with('success', 'Teacher added successfully');
    }

    // Prep data for edit view
    public function edit(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    // Sync changes and manage file disk
    public function update(Request $request, string $id)
    {
        $teacher = Teacher::findOrFail($id);

        $data = $this->validateTeacher($request, $teacher->id);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
                Storage::disk('public')->delete($teacher->image);
            }
            $data['image'] = $request->file('image')->store('teachers', 'public');
        }

        $teacher->update($data);

        return redirect()->route('teachers-index')
            ->with('success', 'Teacher updated successfully');
    }

    // Trigger soft delete (uses Eloquent Trait)
    public function destroy($id)
    {
        Teacher::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // Sidebar link: Deleted Teachers
    public function trashed()
    {
        return view('admin.teachers.trashed');
    }

    // JSON source for trash table
    public function trashedData()
    {
        $teachers = Teacher::onlyTrashed()->select(['id', 'name', 'email', 'subject', 'image']);

        return DataTables::of($teachers)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    $imageUrl = asset('storage/' . $row->image);
                    return '<img src="' . $imageUrl . '" width="50" class="img-thumbnail" alt="Teacher Image">';
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

    // Revert soft-deleted state
    public function restore($id)
    {
        Teacher::withTrashed()->findOrFail($id)->restore();
        return response()->json(['success' => true]);
    }

    // Final removal from disk and database
    public function forceDelete($id)
    {
        $teacher = Teacher::withTrashed()->findOrFail($id);

        if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
            Storage::disk('public')->delete($teacher->image);
        }

        $teacher->forceDelete();
        return response()->json(['success' => true]);
    }

    // Controller-level validaton
    private function validateTeacher(Request $request, $id = null)
    {
        return $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:teachers,email,' . $id,
            'subject' => 'required|string|max:255',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'subject.required' => 'The subject field is required.',
            'image.image'   => 'The file must be an image.',
            'image.mimes'   => 'The image must be a type of jpeg, png, jpg, gif.',
            'image.max'     => 'The image size must not exceed 2MB.',
        ]);
    }
}
