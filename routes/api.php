<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Select All
Route::get('article', [ArticleController::class , 'index']);

// Select One
Route::get('article/{article}', [ArticleController::class , 'show']); // Sur la route Article, la route selecionner appel le controller et utilise la méthode 'Show'.

// Create One
Route::post('article', [ArticleController::class , 'store']);

// Update:put
Route::put('article/{article}', [ArticleController::class , 'update']);

// Delete:delete
Route::delete('article/{article}', [ArticleController::class , 'destroy']);