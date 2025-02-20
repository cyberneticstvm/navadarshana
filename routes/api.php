<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('student')->controller(ApiController::class)->group(function () {
    Route::post('/authenticate', 'authenicate')->name('user.authenticate');
    Route::post('/syllabuses', 'getStudentSyllabuses')->name('student.syllabuses');
    Route::post('/modules', 'getStudentModules')->name('student.modules');
});
