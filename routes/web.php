<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookmarkController;

Route::name('search.')->group(function () {
    Route::get('/', [SearchController::class, 'index'])
        ->name('index');
    Route::get('/search/{city}', [SearchController::class, 'show'])
        ->name('show');
});

Route::name('bookmark.')->group(function () {
    Route::get('/bookmark', [BookmarkController::class, 'index'])
        ->name('index');
    Route::post('/bookmark/{slug}', [BookmarkController::class, 'updateStatus'])
        ->name('update');
});

Auth::routes();
