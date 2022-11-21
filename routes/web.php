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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/program', 'ProgramController@index');
$router->get('/program/{id}', 'ProgramController@detail');

$router->get('/donasi', 'DonasiController@index');
$router->get('/donasi/{id}', 'DonasiController@detail');

$router->group(['prefix' => 'auth'], function () use ($router){
    $router->post("/register", "AuthController@register");
    $router->post("/login", "AuthController@login");

    $router->put('/program/{id}', 'ProgramController@update');
    $router->delete('/program/{id}', 'ProgramController@delete');
    $router->post('/program', 'ProgramController@store');

    $router->put('/donasi/{id}', 'DonasiController@update');
    $router->delete('/donasi/{id}', 'DonasiController@delete');
    $router->post('/donasi', 'DonasiController@store');

});