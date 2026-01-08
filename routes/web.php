<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Redirect root to admin dashboard
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/admin/dashboard', function () {
    $studentCount = Student::count();
    $teacherCount = Teacher::count();

    return view('admin.layouts.dashboard', compact('studentCount', 'teacherCount'));
})->middleware(['auth', 'verified'])->name('admin.dashboard');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {

        // =====================
        // STUDENTS
        // =====================
        Route::get('/students', [StudentController::class, 'index'])
            ->name('students-index');

        Route::get('/students/data', [StudentController::class, 'data'])
            ->name('students-data');

        Route::get('/students/create', function () {
            return view('admin.students.create');
        })->name('students-create');

        Route::post('/students', [StudentController::class, 'store'])
            ->name('students-store');

        Route::get('/students/{id}/edit', [StudentController::class, 'edit'])
            ->name('students-edit');

        Route::post('/students/{id}', [StudentController::class, 'update'])
            ->name('students-update');

        Route::delete('/students/{id}', [StudentController::class, 'destroy'])
            ->name('students-delete');



        // =====================
        // TEACHERS (DATATABLE)
        // =====================
        Route::get('/teachers', [TeacherController::class, 'index'])
            ->name('teachers-index');

        Route::get('/teachers/data', [TeacherController::class, 'data'])
            ->name('teachers-data');

        Route::get('/teachers/create', function () {
            return view('admin.teachers.create');
        })->name('teachers-create');

        Route::post('/teachers', [TeacherController::class, 'store'])
            ->name('teachers-store');

        Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])
            ->name('teachers-edit');

        Route::post('/teachers/{id}', [TeacherController::class, 'update'])
            ->name('teachers-update');

        Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])
            ->name('teachers-delete');
    });
});

require __DIR__ . '/auth.php';
