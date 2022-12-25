<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ResumeController;
use App\Http\Controllers\Api\v1\VacancyController;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api/v1" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/signup', [AuthController::class, 'signup'])->name('Signup');
Route::post('/auth/login', [AuthController::class, 'login'])->name('Login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/resume/create', [ResumeController::class, 'create']);
    Route::get('/resume/index', [ResumeController::class, 'index']);
    Route::delete('/resume/delete/{id}', [ResumeController::class, 'delete']);

    Route::post('/vacancy/create', [VacancyController::class, 'create']);
    Route::get('/vacancy/index', [VacancyController::class, 'index']);
    Route::get('/vacancy/view/{id}', [VacancyController::class, 'view']);
    Route::get('/vacancy/click/{id}', [VacancyController::class, 'click']);
    Route::get('/vacancy/related', [VacancyController::class, 'related']);
    Route::get('/vacancy/clicks', [VacancyController::class, 'clicks']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
