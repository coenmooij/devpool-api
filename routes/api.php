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
                Route::post('/developers', 'DeveloperController@create');
                Route::get('/developers/{id}', 'DeveloperController@getOne');
                Route::patch('/developers/{id}', 'DeveloperController@update');

                Route::get('/developers/{id}/links', 'LinkController@getByDeveloper');
                Route::post('/developers/{id}/links', 'LinkController@create');
                Route::patch('/developers/{id}/links', 'LinkController@update');
                Route::delete('/developers/{id}/links', 'LinkController@delete');

                Route::get('/developers/{id}/technologies', 'TechnologyController@get'); // TODO : Implement later
                Route::post('/developers/{id}/technologies', 'TechnologyController@create'); // TODO : Implement later
                Route::patch('/developers/{id}/technologies', 'TechnologyController@update'); // TODO : Implement later
                Route::delete('/developers/{id}/technologies', 'TechnologyController@delete'); // TODO : Implement later

                Route::get('/developers/{id}/answers', 'AnswerController@get'); // TODO : Implement later
                Route::post('/developers/{id}/answers', 'AnswerController@create'); // TODO : Implement later
                Route::patch('/developers/{id}/answers', 'AnswerController@update'); // TODO : Implement later
                Route::delete('/developers/{id}/answers', 'AnswerController@delete'); // TODO : Implement later

                Route::post('/forms', 'FormController@create'); // TODO : Implement later
            }
        );
    }
);
