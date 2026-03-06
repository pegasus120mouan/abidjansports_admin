<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FlashInformationController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SousCategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/storage-proxy/{path}', [ImageController::class, 'show'])->where('path', '.*')->name('storage.proxy');

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleController::class)->except(['show']);
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class)->except(['show', 'create']);
    Route::resource('sous-categories', SousCategoryController::class)->except(['show', 'create']);
    Route::resource('flash-informations', FlashInformationController::class)->except(['show']);
    Route::patch('flash-informations/{flashInformation}/toggle', [FlashInformationController::class, 'toggleStatus'])->name('flash-informations.toggle');
});
