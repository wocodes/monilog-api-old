<?php


use Illuminate\Support\Facades\Route;

Route::middleware('jwt.auth')->group(function($router) {
    $router->prefix('/expenses')->group(function($router) {
        $router->get('/', 'ExpenseController@index');
        $router->get('/today', 'ExpenseController@today');
        $router->get('/current-month', 'ExpenseController@currentMonth');
        $router->get('/{year}/{month?}', 'ExpenseController@yearMonth');
        $router->post('/', 'ExpenseController@store');
    });
});
