<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/question', 'QuestionController@showQuestion');
    Route::get('/', 'LocationController@showLocationChoice');
    Route::post('/', 'LocationController@setLocation');
});

Route::group(['prefix' => 'api/v1', 'middleware' => ['api']], function () {
    Route::post('/guess', 'API\AnswerController@guess');
    Route::get('/options', 'QuestionController@getOptions');
    Route::get('/test', 'QuestionController@test');
});
