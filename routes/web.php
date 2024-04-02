<?php

use App\Models\Term;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\Curriculum;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'term' => Term::get(),
        'curriculum' => Curriculum::with('course', 'teacher')->get(),
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/teacherlist', [SchoolController::class, 'viewTeacherlist'])
->middleware(['auth', 'verified'])->name('teacherlist');

Route::get('/curriculumlist', function () {
    $termlist = Term::get();
    return Inertia::render('CurriculumList', [
        'response' => $termlist,
    ]);
})->middleware(['auth', 'verified'])->name('curriculumlist');

Route::get('/curriculumadd', [SchoolController::class, 'curriculumAdd']
)->middleware(['auth', 'verified'])->name('curriculumadd');

Route::get('/curriculumedit', function () {
    return Inertia::render('CurriculumEdit');
})->middleware(['auth', 'verified'])->name('curriculumedit');

Route::get('/teacheredit', function () {
    return Inertia::render('TeacherEdit');
})->middleware(['auth', 'verified'])->name('teacheredit');

Route::get('/teacheradd', function () {
    $courselist = Course::get();
    return Inertia::render('TeacherAdd', [
        'response' => $courselist,
    ]);
})->middleware(['auth', 'verified'])->name('teacheradd');

Route::get('/courseadd', function () {
    return Inertia::render('CourseAdd');
})->middleware(['auth', 'verified'])->name('courseadd');

Route::get('/courseedit', function () {
    return Inertia::render('CourseEdit');
})->middleware(['auth', 'verified'])->name('courseedit');

Route::get('/courselist', [SchoolController::class, 'viewCourselist'])->middleware(['auth', 'verified'])->name('courselist');
Route::post('/courseedit', [SchoolController::class, 'editCourse'])->middleware(['auth', 'verified'])->name('courseedit');
Route::post('/teacheredit', [SchoolController::class, 'editTeacher'])->middleware(['auth', 'verified'])->name('teacheredit');
Route::post('/course-save', [SchoolController::class, 'courseSave'])->middleware(['auth', 'verified'])->name('courseedit');
Route::post('/teacher-save', [SchoolController::class, 'teacherSave'])->middleware(['auth', 'verified'])->name('teacheredit');
Route::post('/coursedelete', [SchoolController::class, 'deleteCourse'])->middleware(['auth', 'verified'])->name('coursedelete');
Route::post('/teacherdelete', [SchoolController::class, 'deleteTeacher'])->middleware(['auth', 'verified'])->name('teacherdelete');
Route::post('/teacher-add', [SchoolController::class, 'teacherAdd'])->middleware(['auth', 'verified'])->name('teacher-add');
Route::post('/course-add', [SchoolController::class, 'courseAdd'])->middleware(['auth', 'verified'])->name('course-add');
Route::post('/curriculum-save', [SchoolController::class, 'curriculumSave'])->middleware(['auth', 'verified'])->name('urriculum-save');
Route::post('/curriculumedit', [SchoolController::class, 'editCurriculum'])->middleware(['auth', 'verified'])->name('curriculumedit');
Route::post('/curriculum-update', [SchoolController::class, 'curriculumUpdate'])->middleware(['auth', 'verified'])->name('curriculum-update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
