<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// >>> ========================
// 1 auth для Laravel Passport Package OAuth2
Route::prefix('auth')->group(function () {
    // регистрация
    Route::post('/signup', 'AutherController@signUp');
    // авторизация
    Route::post('/signin', 'AutherController@signIn')->name('signin');
});


Route::group(['middleware' => ['auth:api']], function () {

    Route::prefix('admin')->group(function () {
        // проверка доступа по bearer token
        Route::post('/access', 'AdminController@access');
        // выборка 20 компаний для создания клиента в админке
        Route::post('/company/select_for_people', 'CompanyController@selectTwenty');

        Route::resource('/company', 'CompanyController')->only([
            'store', 'update', 'index', 'destroy'
        ]);
        Route::resource('/client', 'PeopleController')->only([
            'store', 'update', 'index', 'destroy'
        ]);
    });
});
