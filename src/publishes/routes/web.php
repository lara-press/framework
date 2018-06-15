<?php

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

/** @var LaraPress\Routing\Router $router */

$router->any('/', 'PageController@handle');
$router->handle(\App\Page::class, 'PageController@handle');
$router->handle(\App\Post::class, 'PostController@handle');
