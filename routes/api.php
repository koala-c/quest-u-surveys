<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerOptionController;
use App\Http\Controllers\ResponseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Enquestador Endpoints
Route::get('/users', [UserController::class, 'index']);
Route::get('/get-user/{id}', [UserController::class, 'show']);
Route::post('/create-user', [UserController::class, 'store']);
Route::put('/update-user/{id}', [UserController::class, 'update']);
Route::delete('/delete-user/{id}', [UserController::class, 'destroy']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:api');

// Enquesta Endpoints
Route::get('/surveys', [SurveyController::class, 'index']);
Route::get('/get-survey/{id}', [SurveyController::class, 'show']);
Route::get('/get-survey-user/{userid}', [SurveyController::class, 'showFromUser']);
Route::post('/create-survey', [SurveyController::class, 'store']);
Route::put('/update-survey/{id}', [SurveyController::class, 'update']);
Route::delete('/delete-survey/{id}', [SurveyController::class, 'destroy']);

// Pregunta Endpoints
Route::get('/questions', [QuestionController::class, 'index']);
Route::get('/get-question/{id}', [QuestionController::class, 'show']);
Route::get('/get-question-survey/{surveyid}', [QuestionController::class, 'showFromSurvey']);
Route::post('/create-question', [QuestionController::class, 'store']);
Route::put('/update-question/{id}', [QuestionController::class, 'update']);
Route::delete('/delete-question/{id}', [QuestionController::class, 'destroy']);

// Resposta Endpoints
Route::get('/responses', [ResponseController::class, 'index']);
Route::get('/get-response/{id}', [ResponseController::class, 'show']);
Route::get('/get-response-survey/{surveyid}', [ResponseController::class, 'showFromSurvey']);
Route::post('/create-response', [ResponseController::class, 'store']);
Route::put('/update-response/{id}', [ResponseController::class, 'update']);
Route::delete('/delete-response/{id}', [ResponseController::class, 'destroy']);
