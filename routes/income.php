<?php


use Illuminate\Support\Facades\Route;

Route::middleware('jwt.auth')->group(function($router) {
    $router->prefix('income')->group(function($router) {
        $router->post('/', 'IncomeController@store');
    });
});
