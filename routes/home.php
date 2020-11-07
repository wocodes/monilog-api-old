<?php

use Illuminate\Support\Facades\Route;

Route::middleware('jwt.auth')->prefix('/stats')->group(function($router) {
    $router->get('/', 'HomeController@dashboard');
});

