<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/token','Auth\LoginController@getToken');
Route::get('/questions','Api\QuestionsController@index');
Route::get('/questions/{question}-{slug}','Api\QuestionDetailsController');
Route::get('/questions/{question}/answers','Api\AnswersController@index');

Route::middleware('auth:api')->group(function(){
    Route::apiResource('/questions','Api\QuestionsController')->except('index');    
    Route::apiResource('/questions.answers','Api\AnswersController')->except('index');    

    Route::post('/questions/{question}/vote','Api\VotesController@vote_question');
    Route::post('/answers/{answer}/vote','Api\VotesController@vote_answer');

    Route::post('/questions/{question}/favorites','Api\FavoritesController@store');
    Route::delete('/questions/{question}/favorites','Api\FavoritesController@destroy');
    Route::get('/my-post','Api\UserPostsController');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user(); 
});
