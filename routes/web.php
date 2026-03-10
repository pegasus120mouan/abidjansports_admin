<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FlashInformationController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SousCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Editeur\DashboardController as EditeurDashboardController;
use App\Http\Controllers\Editeur\ArticleController as EditeurArticleController;
use App\Http\Controllers\Editeur\CategoryController as EditeurCategoryController;
use App\Http\Controllers\Editeur\FlashInformationController as EditeurFlashInformationController;
use Illuminate\Support\Facades\Route;

Route::get('/storage-proxy/{path}', [ImageController::class, 'show'])->where('path', '.*')->name('storage.proxy');

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:administrateur'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('articles', ArticleController::class)->except(['show']);
    Route::get('articles/{article}/preview', [ArticleController::class, 'preview'])->name('articles.preview');
    Route::patch('articles/{article}/publish', [ArticleController::class, 'publish'])->name('articles.publish');
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/update-name', [UserController::class, 'updateName'])->name('users.update-name');
    Route::patch('users/{user}/update-contact', [UserController::class, 'updateContact'])->name('users.update-contact');
    Route::patch('users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update-password');
    Route::patch('users/{user}/update-avatar', [UserController::class, 'updateAvatar'])->name('users.update-avatar');
    Route::resource('categories', CategoryController::class)->except(['show', 'create']);
    Route::resource('sous-categories', SousCategoryController::class)->except(['show', 'create']);
    Route::resource('flash-informations', FlashInformationController::class)->except(['show']);
    Route::patch('flash-informations/{flashInformation}/toggle', [FlashInformationController::class, 'toggleStatus'])->name('flash-informations.toggle');
    Route::resource('journals', JournalController::class);
});

Route::middleware(['auth', 'role:editeur'])->prefix('editeur')->name('editeur.')->group(function () {
    Route::get('/', [EditeurDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('articles', EditeurArticleController::class)->except(['show']);
    Route::get('articles/{article}/preview', [EditeurArticleController::class, 'preview'])->name('articles.preview');
    Route::patch('articles/{article}/publish', [EditeurArticleController::class, 'publish'])->name('articles.publish');
    
    Route::get('categories', [EditeurCategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [EditeurCategoryController::class, 'store'])->name('categories.store');
    Route::post('sous-categories', [EditeurCategoryController::class, 'storeSousCategory'])->name('sous-categories.store');
    
    Route::resource('flash-informations', EditeurFlashInformationController::class)->except(['show']);
    Route::patch('flash-informations/{flashInformation}/toggle', [EditeurFlashInformationController::class, 'toggleStatus'])->name('flash-informations.toggle');
});
