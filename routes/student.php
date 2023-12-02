<?php

use App\Http\Controllers\Shared\CommentController;
use App\Http\Controllers\Shared\EnrollController;
use App\Http\Controllers\Student\TopicController;
use Illuminate\Support\Facades\Route;

Route::prefix('topics')->name('topic.')->controller(TopicController::class)->group(function () {
    Route::get('/class/{classId}', 'getTopicByClass');
});

Route::get('/enrolled-classes', [EnrollController::class, 'readEnrolledClasses']);

Route::post('/topics/{topicId}/comments', [CommentController::class, 'store']);
Route::get('/topics/{topicId}/comments', [CommentController::class, 'getCommentsByTopic']);
