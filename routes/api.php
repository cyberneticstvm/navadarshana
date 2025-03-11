<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('student')->controller(ApiController::class)->group(function () {
    Route::post('/authenticate', 'authenicate')->name('user.authenticate');
    Route::post('/student', 'getStudent')->name('get.student');
    Route::post('/batches', 'getStudentBatches')->name('student.batches');
    Route::post('/syllabuses', 'getStudentSyllabuses')->name('student.syllabuses');
    Route::post('/modules', 'getStudentModules')->name('student.modules');
    Route::post('/topics', 'getStudentTopics')->name('student.topics');
    Route::post('/notes', 'getStudentNotes')->name('student.notes');
    Route::post('/note/single', 'getNote')->name('note.single');
    Route::post('/note/single/attachments', 'getNoteAttachments')->name('note.single.attachments');

    Route::post('/class/schedule', 'getClassSchedule')->name('get.class.schedule');
    Route::post('/videos/recorded', 'getRecordedVideos')->name('get.recorded.videos');

    Route::post('/update/password', 'updatePassword')->name('update.password');
});
