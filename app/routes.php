<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/my/new/all/tables', 'UsersController@migrate');

Route::get('/', 'SectionsController@my_section');

Route::group(array('before'=> 'csrf'), function()
{
Route::get('users/registration', 'UsersController@registration');
Route::post('users/form', array('before'=>'csrf', 'as' => 'form', 'uses' => 'UsersController@store'));
Route::post('users/login', array('before'=>'csrf', 'as' => 'login', 'uses' => 'UsersController@login'));

Route::get('users/google',  array('before'=>'csrf', 'uses' => 'UsersController@loginWithGoogle'));
});

Route::get('oauth2callback', 'UsersController@loginWithGoogle');


Route::group(array('before'=> 'user'), function()
{
    Route::group(array('before'=> 'csrf'), function()
    {
Route::post('users/logout', array('as' => 'logout', 'uses' => 'UsersController@getLogout'));
Route::get('sections/index', 'SectionsController@index');
Route::post('sections/store', array( 'as' => 'art_record', 'uses' => 'SectionsController@store'));
Route::get('articles/show', 'ArticlesController@show');
Route::any('articles/index', array('as' => 'index', 'uses' => 'ArticlesController@index'));
Route::get('art_read', 'ArticlesController@read');
Route::get('favorite_ajax', 'ArticlesController@favorite_ajax');
Route::get('articles/favorite_ajax', 'ArticlesController@favorite_ajax');
Route::get('articles/favorite', 'ArticlesController@favorite');
Route::get('show_ajax', 'ArticlesController@show');
Route::get('articles/favorite_delete', 'ArticlesController@deleteFavorite');
Route::post('articles/delete_fav_form', array('as' => 'del_fav', 'uses' =>  'ArticlesController@delFavForm'));
    });
});