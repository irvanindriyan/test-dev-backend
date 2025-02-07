<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Middleware\OnlyJsonRequest;

Route::get('/', [
	Controller::class, 
	'index'
]);
Route::middleware([
	OnlyJsonRequest::class
])->prefix('questions')->group(function () {
	Route::get('/', [App\Http\Controllers\Api\QuestionsController::class, 'callbackAnswer'])->name('questions');
	Route::get('/1', [App\Http\Controllers\Api\QuestionsController::class, 'callbackAnswerOne'])->name('questions.1');
	Route::post('/2', [App\Http\Controllers\Api\QuestionsController::class, 'callbackAnswerTwo'])->name('questions.2');
	Route::post('/3', [App\Http\Controllers\Api\QuestionsController::class, 'callbackAnswerThree'])->name('questions.3');
	Route::post('/4', [App\Http\Controllers\Api\QuestionsController::class, 'callbackAnswerFour'])->name('questions.4');
	Route::post('/5', [App\Http\Controllers\Api\QuestionsController::class, 'callbackAnswerFive'])->name('questions.5');
	Route::post('/6', [App\Http\Controllers\Api\QuestionsController::class, 'callbackAnswerSix'])->name('questions.6');
	Route::post('/7', [App\Http\Controllers\Api\QuestionsController::class, 'callbackAnswerSeven'])->name('questions.7');
	Route::post('/8', [App\Http\Controllers\Api\QuestionsController::class, 'callbackAnswerEight'])->name('questions.8');
	Route::get('/9', [App\Http\Controllers\Api\QuestionsController::class, 'callbackAnswerNine'])->name('questions.9');
});