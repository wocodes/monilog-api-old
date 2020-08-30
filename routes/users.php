<?php

use Illuminate\Support\Facades\Route;

Route::post('/user/login', 'AuthController@login');
Route::post('/user/register', 'AuthController@register');

