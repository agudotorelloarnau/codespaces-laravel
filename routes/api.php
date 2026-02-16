<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Api\SeriesController;
use App\Http\Controllers\Api\MovieController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/students', [StudentController::class, 'index']);

Route::get('/students/{id}', [StudentController::class, 'estudiante2']);

Route::get('/series', [SeriesController::class, 'index']);
Route::get('/series/{id}', [SeriesController::class, 'show']);
Route::post('/series', [SeriesController::class, 'store']);
Route::put('/series/{id}', [SeriesController::class, 'update']);
Route::delete('/series/{id}', [SeriesController::class, 'destroy']);

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);
Route::post('/movies', [MovieController::class, 'store']);
Route::put('/movies/{id}', [MovieController::class, 'update']);
Route::delete('/movies/{id}', [MovieController::class, 'destroy']);

//Route::post('/students', function () { return 'Crear student'; });

//Route::put('/students/{id}', function () { return 'Actualizar student'; });

//Route::delete('/students/{id}', function () { return 'Eliminar student'; });

//Route::get('/students/{id}', function () {return 'Lista de Students'; });
