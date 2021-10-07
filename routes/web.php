<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/search', 'SearchController@search');

$router->group(['prefix'=>'contact'], function() use($router){
    $router->get('/', 'ContactsController@index');
    $router->post('/', 'ContactsController@create');
    $router->get('/{id}', 'ContactsController@show');
    $router->put('/{id}', 'ContactsController@update');
    $router->delete('/{id}', 'ContactsController@destroy');
});

$router->group(['prefix'=>'category'], function() use($router){
    $router->get('/', 'CategoryController@index');
    $router->post('/', 'CategoryController@create');
    $router->get('/{id}', 'CategoryController@show');
    $router->put('/{id}', 'CategoryController@update');
    $router->put('/{category_id}/{contact_id}', 'CategoryController@add_contact');
    $router->delete('/{category_id}/{contact_id}', 'CategoryController@delete_contact');
    $router->delete('/{id}', 'CategoryController@destroy');
});

$router->group(['prefix'=>'favorite'], function() use($router){
    $router->get('/', 'FavoriteController@index');
    $router->put('/{contact_id}', 'FavoriteController@add_contact');
    $router->delete('/{contact_id}', 'FavoriteController@delete_contact');
});
