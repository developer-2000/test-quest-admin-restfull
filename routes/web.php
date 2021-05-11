<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// ================================================================================================
// Группа функций административной панели ==========================================================
// ================================================================================================
Route::prefix('admin')->group( function () {
    Route::get('/', 'AdminController@adminPanel');
    // загрузка авторизации
    Route::get('/auth', 'AdminController@adminAuth');
    Route::get('/company', 'AdminController@company');
    Route::get('/client', 'AdminController@client');
});
