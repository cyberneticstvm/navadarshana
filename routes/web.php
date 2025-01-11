<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
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

    Route::prefix('ajax')->controller(AjaxController::class)->group(function () {
        Route::get('/student/detail/{id}', 'getStudentDetails')->name('get.student.details');
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
});

require __DIR__ . '/auth.php';
