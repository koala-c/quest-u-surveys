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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', [UserController::class, 'index']);
Route::get('/get-user/{id}', [UserController::class, 'show']);
Route::post('/create-user', [UserController::class, 'store']);
Route::put('/update-user/{id}', [UserController::class, 'update']);
Route::delete('/delete-user/{id}', [UserController::class, 'destroy']);
Route::delete('/login', [UserController::class, 'login']);

// Surveys
Route::get('/surveys', 'SurveyController@index');
Route::get('/surveys/{survey}', 'SurveyController@show')->where('survey', '[0-9]+'); // Route with ID constraint

// Questions (within Surveys)
Route::get('/surveys/{survey}/questions', 'QuestionController@index')->where('survey', '[0-9]+'); // List questions for a survey
Route::post('/surveys/{survey}/questions', 'QuestionController@store')->where('survey', '[0-9]+'); // Create a question for a survey

// Answer Options (within Questions)
Route::post('/questions/{question}/answer-options', 'AnswerOptionController@store')->where('question', '[0-9]+'); // Create an answer option for a question
