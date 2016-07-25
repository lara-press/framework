<?php

/** @var LaraPress\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Designer;
use App\Page;

$router->get('/', 'PagesController@frontPage');

$router->handle(Page::class, 'PagesController@defaultPage');
$router->handle(Designer::class, 'DesignerController@show');

$router->get('products/{term}', 'ProductController@index');
$router->get('product/{product}', 'ProductController@show');

$router->post('submit-contact', 'ContactController@submit');
