<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('authentication')->namespace('CoenMooij\DevpoolApi\Authentication')->group(
    function () {
        Route::post('/login', 'AuthenticationController@login');
        Route::post('/register-developer', 'AuthenticationController@registerDeveloper');
        Route::post('/resetPassword', 'AuthenticationController@resetPassword');
        Route::get('/logout', 'AuthenticationController@logout')->middleware('auth');
    }
);

Route::middleware('auth')->group(
    function () {
        Route::namespace('CoenMooij\DevpoolApi\Developer')->group(
            function () {
                Route::get('/developers', 'DeveloperController@getAll');
                Route::get('/developers/{id}', 'DeveloperController@getOne');
            }
        );
    }
);
