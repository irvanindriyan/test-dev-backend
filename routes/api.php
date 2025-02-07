<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\OnlyJsonRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\QuestionsController;

Route::get('/', [
	Controller::class, 
	'index'
]);
Route::middleware([
	OnlyJsonRequest::class
])->prefix('questions')->group(function () {
	Route::get('/', [
		QuestionsController::class, 'callbackAnswer'
	])->name('questions');
	Route::get('/1', [
		QuestionsController::class, 'callbackAnswerOne'
	])->name('questions.1');
	Route::post('/2', [
		QuestionsController::class, 'callbackAnswerTwo'
	])->name('questions.2');
	Route::post('/3', [
		QuestionsController::class, 'callbackAnswerThree'
	])->name('questions.3');
	Route::post('/4', [
		QuestionsController::class, 'callbackAnswerFour'
	])->name('questions.4');
	Route::post('/5', [
		QuestionsController::class, 'callbackAnswerFive'
	])->name('questions.5');
	Route::post('/6', [
		QuestionsController::class, 'callbackAnswerSix'
	])->name('questions.6');
	Route::post('/7', [
		QuestionsController::class, 'callbackAnswerSeven'
	])->name('questions.7');
	Route::post('/8', [
		QuestionsController::class, 'callbackAnswerEight'
	])->name('questions.8');
	Route::get('/9', [
		QuestionsController::class, 'callbackAnswerNine'
	])->name('questions.9');
});