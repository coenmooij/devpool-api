<?php

use Illuminate\Support\Facades\Route;

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
            }
        );
        Route::namespace('CoenMooij\DevpoolApi\Profile')->group(
            function () {
                Route::get('/developers/{id}/links', 'LinkController@getByDeveloper');
                Route::post('/developers/{id}/links', 'LinkController@create');
                Route::get('/links/{id}', 'LinkController@getOne');
                Route::patch('/links/{id}', 'LinkController@update');
                Route::delete('/links/{id}', 'LinkController@delete');
            }
        );
        Route::namespace('CoenMooij\DevpoolApi\CRM')->group(
            function () {
                Route::get('/developers/{id}/comments', 'CommentController@getByDeveloper');
                Route::post('/developers/{id}/comments', 'CommentController@create');
                Route::get('/comments/{id}', 'CommentController@getOne');
                Route::patch('/comments/{id}', 'CommentController@update');
                Route::delete('/comments/{id}', 'CommentController@delete');
            }
        );
        Route::namespace('CoenMooij\DevpoolApi\Technology')->group(
            function () {
                Route::get('/developers/{id}/technologies', 'TechnologyController@getByDeveloper');
                Route::post('/developers/{id}/technologies', 'TechnologyController@addToDeveloper');
                Route::delete('/developers/{id}/technologies','TechnologyController@removeFromDeveloper');
            }
        );

        Route::get('/developers/{id}/answers', 'AnswerController@get'); // TODO : Implement later
        Route::post('/developers/{id}/answers', 'AnswerController@create'); // TODO : Implement later
        Route::patch('/developers/{id}/answers', 'AnswerController@update'); // TODO : Implement later
        Route::delete('/developers/{id}/answers', 'AnswerController@delete'); // TODO : Implement later

        Route::post('/forms', 'FormController@create'); // TODO : Implement later
    }
);
