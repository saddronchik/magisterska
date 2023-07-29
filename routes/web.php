<?php

use App\Http\Controllers\Api\v1\MeasuresController;
use App\Http\Controllers\Api\v1\UsersController;
use Illuminate\Support\Facades\Route;

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');


Route::get('/admin/api/showMesures/{id}', function () {
    return view('mesures.show');
});


// Auth::routes();

