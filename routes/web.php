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

/* Users Routes

Here is where i registered all of the routes for users.
*/

$router->post('/user', 'userController@createUser');
$router->get('/user', 'userController@getAllUsers');
$router->get('/user/{userUuid}', 'userController@getUser');
$router->put('/user/{userUuid}', 'userController@updateUser');
$router->delete('/user/{userUuid}', 'userController@deleteUser');

/* Articles Routes

Here is where i registered all of the routes for articles.
*/

$router->post('/article', 'articleController@createArticle');
$router->get('/article', 'articleController@getAllArticles');
$router->get('/article/{articleUuid}', 'articleController@getArticle');
$router->put('/article/{articleUuid}', 'articleController@updateArticle');
$router->delete('/article/{articleUuid}', 'articleController@deleteArticle');


