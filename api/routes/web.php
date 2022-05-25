<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/web-init', 'WebInit');

Route::namespace('Auth')->group(function () {
    Route::prefix('login')->group(function () {
        Route::get('{provider}', 'Login');
        Route::get('{provider}/callback', 'LoginCallback');
    });
});

Route::group([
    'prefix' => 'organizations',
    'namespace' => 'Organizations',
    'middleware' => 'auth',
], function () {
    Route::post('', 'Store');
    Route::get('', 'Get');
    Route::get('{organization}', 'Show');
    Route::put('{organization}', 'Update');
    Route::delete('{organization}', 'Delete');
});
