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

Route::post('/user/login', 'AuthController@login');
Route::post('/user/register', 'AuthController@register');

Route::middleware('jwt.auth')->get('/user', function (Request $request) {
    return auth('api')->user();
});

Route::middleware('jwt.auth')->group(function($router) {
    $router->prefix('/expense')->group(function($router) {
        $router->get('/', 'ExpenseController@index');
        $router->post('/', 'ExpenseController@store');
    });
});
