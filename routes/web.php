<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeController;

Route::name('search.')->group(function () {
    Route::get('/', [SearchController::class, 'index'])
        ->name('index');
    Route::get('/search/{city}', [SearchController::class, 'show'])
        ->name('show');
});

Route::get('/bookmark', [HomeController::class, 'index'])
    ->name('bookmark');

Auth::routes();
