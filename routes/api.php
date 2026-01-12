<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/students', [StudentController::class, 'index']);

Route::post('/students', function () { return 'Creating student'; });

Route::put('/students/{id}', function () { return 'Updating student'; });

Route::delete('/students/{id}', function () { return 'Deleti student'; });

Route::get('/students/{id}', function () {return 'Getting one student'; });
