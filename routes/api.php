<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecetasController;

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

Route::get('/recetas', [RecetasController::class, 'index']);
Route::post('/recetas', [RecetasController::class, 'store'])->middleware('auth:sanctum');
Route::put('/recetas/{receta}', [RecetasController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/recetas/{receta}', [RecetasController::class, 'destroy'])->middleware('auth:sanctum');
