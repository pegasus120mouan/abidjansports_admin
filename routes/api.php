<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FlashInformationController;
use App\Http\Controllers\Api\JournalController;
use App\Http\Controllers\Api\VisiteController;

/*
|--------------------------------------------------------------------------
| Routes publiques (sans authentification)
|--------------------------------------------------------------------------
*/

// Articles
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/latest', [ArticleController::class, 'latest']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);
Route::get('/articles/category/{slug}', [ArticleController::class, 'byCategory']);
Route::get('/articles/sous-category/{slug}', [ArticleController::class, 'bySousCategory']);

// Catégories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);

// Flash Informations
Route::get('/flash-informations', [FlashInformationController::class, 'index']);

// Journaux (Boutique)
Route::get('/journals', [JournalController::class, 'index']);
Route::get('/journals/latest', [JournalController::class, 'latest']);
Route::get('/journals/{slug}', [JournalController::class, 'show']);

// Visites (tracking)
Route::post('/visite', [VisiteController::class, 'enregistrer']);

// Authentification
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Routes protégées (avec authentification)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
