<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Api\SeriesController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsUserAuth;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//publicas
Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);



//protegidas
Route::middleware([IsUserAuth::class])->group(function () {
    Route::get('/students', [StudentController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'getUser']);
    //Route::post('personajes', [MovieController::class, 'addPersonaje']);
});

Route::get('/students/{id}', [StudentController::class, 'estudiante2']);

//Route::post('/students', function () { return 'Crear student'; });

//Route::put('/students/{id}', function () { return 'Actualizar student'; });

//Route::delete('/students/{id}', function () { return 'Eliminar student'; });

//Route::get('/students/{id}', function () {return 'Lista de Students'; });
