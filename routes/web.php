<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Lcobucci\JWT\Signer\Ecdsa\Sha256;
use Mockery\Configuration;

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

$router->post('/register','Register@register');
//$router->get('/register/{id}','Register@profile');
$router->group(['prefix'=>'/register', 'middleware' => 'checktoken'], function($router){
    $router->get('/{id}', 'Register@profile');
});
$router->post('/login', 'LoginController@login');

$router->group(['prefix'=>'/book', 'middleware' => 'checktoken'], function($router){
    $router->get('/', 'BookController@index');
    $router->get('/{id}', 'BookController@show');
    $router->post('/', 'BookController@store');
    $router->patch('/{id}', 'BookController@update'); 
    $router->delete('/{id}', 'BookController@destroy'); 
});

$router->group(['prefix' => '/recover'], function($router){
    $router->post('/', 'RecoverPasswordController@recover');
});
