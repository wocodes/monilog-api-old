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

require_once 'users.php';

require_once 'expenses.php';

require_once 'income.php';

//require_once 'budget.php';

Route::middleware('jwt.auth')->get('/user', function (Request $request) {
    return auth('api')->user();
});
