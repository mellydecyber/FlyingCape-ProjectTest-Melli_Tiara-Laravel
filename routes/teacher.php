<?php

use App\Http\Controllers\Shared\CommentController;
use App\Http\Controllers\Shared\EnrollController;
use App\Http\Controllers\Teacher\TopicController;
use Illuminate\Support\Facades\Route;

Route::get('/enrolled-classes', [EnrollController::class, 'readEnrolledClasses']);

Route::prefix('topics')->name('topic.')->controller(TopicController::class)->group(function () {
    Route::get('/all', 'index');
    Route::get('/', 'getTopicByTeacher');
    Route::get('/class/{classId}', 'getTopicByClass');
    Route::get('/{topicId}', 'show');
    Route::post('/', 'store');
    Route::put('/{topicId}', 'update');
    Route::delete('/{topicId}', 'destroy');
});

Route::post('/topics/{topicId}/comments', [CommentController::class, 'store'])->name('teacher.comment.store');
Route::get('/topics/{topicId}/comments', [CommentController::class, 'getCommentsByTopic'])->name('teacher.comment.get');;
