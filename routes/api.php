<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', 'Login');
        Route::post('register', 'Register');
    });
});

Route::controller(NewsController::class)->group(function () {
    Route::get('/news', 'GetNews');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/news/create', 'PostNews');
        Route::post('/news/update/{id}', 'EditNews');
    });
});

Route::controller(QuestionController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/questions', 'GetQuestions');
    Route::get('/questions/{id}', 'ShowQuestion');
    Route::post('/questions/create', 'PostQuestions');
});

Route::controller(AnswerController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/answers/{id}', 'PostAnswers');
    Route::post('/answers/change-status/{id}', 'ChangeAnswerStatus');
});

Route::controller(UserController::class)->middleware('auth:sanctum')->group(function(){
    Route::get('/profiles', 'GetUserProfile');
    Route::post('/profiles/update', 'UpdateProfile');
});