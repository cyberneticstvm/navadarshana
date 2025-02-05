<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SyllabusController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::prefix('/dashboard')->controller(UserController::class)->group(function () {
        Route::get('/', 'dashboard')->name('dashboard');
        Route::post('/update/branch', 'updateBranch')->name('user.branch.update');
    });
});

Route::middleware(['web', 'auth', 'branch'])->group(function () {

    Route::prefix('ajax')->controller(AjaxController::class)->group(function () {
        Route::get('/get/ddl', 'getDropDown')->name('get.ddl');

        Route::get('/student/detail/{id}', 'getStudentDetails')->name('get.student.details');
        Route::get('/student/batch/{id}/{action}', 'getStudentDetailsForBatch')->name('get.student.details.for.batch');
        Route::get('/course/syllabus/{id}/{action}', 'getSyllabusForCourse')->name('get.syllabus.for.course');
        Route::get('/syllabus/subject/{id}/{action}', 'getSubjectsForSyllabus')->name('get.subjects.for.syllabus');
        Route::get('/subject/module/{id}/{action}', 'getModulesForSubject')->name('get.modules.for.subject');
        Route::get('/module/topic/{id}/{action}', 'getTopicsForModule')->name('get.topics.for.module');
    });

    Route::prefix('/user')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('user.register');
        Route::get('/create', 'create')->name('user.create');
        Route::post('/create', 'store')->name('user.save');
        Route::get('/edit/{id}', 'edit')->name('user.edit');
        Route::post('/edit/{id}', 'update')->name('user.update');
        Route::get('/delete/{id}', 'destroy')->name('user.delete');
    });

    Route::prefix('/role')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('role.register');
        Route::get('/create', 'create')->name('role.create');
        Route::post('/create', 'store')->name('role.save');
        Route::get('/edit/{id}', 'edit')->name('role.edit');
        Route::post('/edit/{id}', 'update')->name('role.update');
        Route::get('/delete/{id}', 'destroy')->name('role.delete');
    });

    Route::prefix('/branch')->controller(BranchController::class)->group(function () {
        Route::get('/', 'index')->name('branch.register');
        Route::get('/create', 'create')->name('branch.create');
        Route::post('/create', 'store')->name('branch.save');
        Route::get('/edit/{id}', 'edit')->name('branch.edit');
        Route::post('/edit/{id}', 'update')->name('branch.update');
        Route::get('/delete/{id}', 'destroy')->name('branch.delete');
    });

    Route::prefix('/student')->controller(StudentController::class)->group(function () {
        Route::get('/', 'index')->name('student.register');
        Route::get('/create', 'create')->name('student.create');
        Route::post('/create', 'store')->name('student.save');
        Route::get('/edit/{id}', 'edit')->name('student.edit');
        Route::post('/edit/{id}', 'update')->name('student.update');
        Route::get('/delete/{id}', 'destroy')->name('student.delete');
    });

    Route::prefix('/course')->controller(CourseController::class)->group(function () {
        Route::get('/', 'index')->name('course.register');
        Route::get('/create', 'create')->name('course.create');
        Route::post('/create', 'store')->name('course.save');
        Route::get('/edit/{id}', 'edit')->name('course.edit');
        Route::post('/edit/{id}', 'update')->name('course.update');
        Route::get('/delete/{id}', 'destroy')->name('course.delete');

        Route::post('/syllabus/save', 'courseSyllabusSave')->name('course.syllabus.save');
        Route::get('/syllabus/remove/{id}', 'courseSyllabusRemove')->name('course.syllabus.remove');
        Route::get('/syllabus/restore/{id}', 'courseSyllabusRestore')->name('course.syllabus.restore');
    });

    Route::prefix('/syllabus')->controller(SyllabusController::class)->group(function () {
        Route::get('/', 'index')->name('syllabus.register');
        Route::get('/create', 'create')->name('syllabus.create');
        Route::post('/create', 'store')->name('syllabus.save');
        Route::get('/edit/{id}', 'edit')->name('syllabus.edit');
        Route::post('/edit/{id}', 'update')->name('syllabus.update');
        Route::get('/delete/{id}', 'destroy')->name('syllabus.delete');

        Route::post('/subject/save', 'syllabusSubjectSave')->name('syllabus.subject.save');
        Route::get('/subject/remove/{id}', 'syllabusSubjectRemove')->name('syllabus.subject.remove');
        Route::get('/subject/restore/{id}', 'syllabusSubjectRestore')->name('syllabus.subject.restore');
    });

    Route::prefix('/subject')->controller(SubjectController::class)->group(function () {
        Route::get('/', 'index')->name('subject.register');
        Route::get('/create', 'create')->name('subject.create');
        Route::post('/create', 'store')->name('subject.save');
        Route::get('/edit/{id}', 'edit')->name('subject.edit');
        Route::post('/edit/{id}', 'update')->name('subject.update');
        Route::get('/delete/{id}', 'destroy')->name('subject.delete');

        Route::get('/module/remove/{id}', 'subjectModuleRemove')->name('subject.module.remove');
        Route::get('/module/restore/{id}', 'subjectModuleRestore')->name('subject.module.restore');
    });

    Route::prefix('/module')->controller(ModuleController::class)->group(function () {
        Route::get('/', 'index')->name('module.register');
        Route::get('/create', 'create')->name('module.create');
        Route::post('/create', 'store')->name('module.save');
        Route::get('/edit/{id}', 'edit')->name('module.edit');
        Route::post('/edit/{id}', 'update')->name('module.update');
        Route::get('/delete/{id}', 'destroy')->name('module.delete');

        Route::get('/topic/remove/{id}', 'moduleTopicRemove')->name('module.topic.remove');
        Route::get('/topic/restore/{id}', 'moduleTopicRestore')->name('module.topic.restore');
    });

    Route::prefix('/topic')->controller(TopicController::class)->group(function () {
        Route::get('/', 'index')->name('topic.register');
        Route::get('/create', 'create')->name('topic.create');
        Route::post('/create', 'store')->name('topic.save');
        Route::get('/edit/{id}', 'edit')->name('topic.edit');
        Route::post('/edit/{id}', 'update')->name('topic.update');
        Route::get('/delete/{id}', 'destroy')->name('topic.delete');
    });

    Route::prefix('/notes')->controller(NotesController::class)->group(function () {
        Route::get('/', 'index')->name('notes.register');
        Route::get('/create', 'create')->name('notes.create');
        Route::post('/create', 'store')->name('notes.save');
        Route::get('/edit/{id}', 'edit')->name('notes.edit');
        Route::post('/edit/{id}', 'update')->name('notes.update');
        Route::get('/delete/{id}', 'destroy')->name('notes.delete');

        Route::get('/view/{id}', 'show')->name('notes.show');
    });

    Route::prefix('/batch')->controller(BatchController::class)->group(function () {
        Route::get('/', 'index')->name('batch.register');
        Route::get('/create', 'create')->name('batch.create');
        Route::post('/create', 'store')->name('batch.save');
        Route::get('/edit/{id}', 'edit')->name('batch.edit');
        Route::post('/edit/{id}', 'update')->name('batch.update');
        Route::get('/delete/{id}', 'destroy')->name('batch.delete');

        Route::post('/student/save', 'save')->name('batch.student.save');
        Route::get('/student/remove/{id}', 'batchStudentRemove')->name('batch.student.remove');
        Route::get('/student/restore/{id}', 'batchStudentRestore')->name('batch.student.restore');
    });

    Route::prefix('/fee')->controller(FeeController::class)->group(function () {
        Route::get('/', 'index')->name('fee.register');
        Route::get('/create/{category}/{student}', 'create')->name('fee.create');
        Route::post('/create', 'store')->name('fee.save');
        Route::get('/edit/{id}', 'edit')->name('fee.edit');
        Route::post('/edit/{id}', 'update')->name('fee.update');
        Route::get('/delete/{id}', 'destroy')->name('fee.delete');
    });
});

require __DIR__ . '/auth.php';
