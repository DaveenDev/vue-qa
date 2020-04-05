<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'QuestionsController@index')->name('home');

Route::resource('questions','QuestionsController')->except('show');
//Route::post('/questions/{question}/answers','AnswerController@store')->name('answers.store');
Route::resource('questions.answers','AnswerController')->except('index','create','show');
Route::get('/questions/{slug}','QuestionsController@show')->name('questions.show');
Route::post('/answers/{answer}/accept','AcceptAnswerController')->name('answers.accept');

Route::post('/questions/{question}/favorites','FavoritesController@store')->name('questions.favorite');
Route::delete('/questions/{question}/favorites','FavoritesController@destroy')->name('questions.unfavorite');


Route::post('/questions/{question}/vote','VotesController@vote_question');
Route::post('/answers/{answer}/vote','VotesController@vote_answer');
