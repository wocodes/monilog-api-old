<?php


use Illuminate\Support\Facades\Route;

Route::middleware('jwt.auth')->group(function($router) {
    $router->prefix('/budgets')->group(function($router) {
        $router->get('/', 'BudgetController@index');
        $router->get('/unlogged', 'BudgetController@unlogged');
        $router->post('/', 'BudgetController@store');
        $router->get('/current-month', 'BudgetController@currentMonth');
    });
});
