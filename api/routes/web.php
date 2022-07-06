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
    Route::group([
        'middleware' => 'can:view,organization',
    ], function () {
        Route::get('/{organization}', 'Show');
        Route::group([
            'prefix' => '{organization}/projects',
            'namespace' => 'Projects',
        ], function () {
            Route::get('', 'Get');
            Route::get('{project}', 'Show');
            Route::post('', 'Store');
        });
    });

    Route::group([
        'middleware' => 'can:edit,project',
    ], function () {
        Route::put('{organization}', 'Update');
    });

    Route::group([
        'middleware' => 'can:manage,project',
    ], function () {
        Route::delete('{organization}', 'Delete');
    });
});

Route::group([
    'prefix' => 'projects',
    'namespace' => 'Projects',
    'middleware' => 'auth',
], function () {
    Route::group([
        'prefix' => '{project}/issues',
        'namespace' => 'Issues',
        'middleware' => 'can:view,project',
    ], function () {
        Route::get('', 'Get');
        Route::post('', 'Store');
    });

    Route::group([
        'prefix' => '{project}/milestones',
        'namespace' => 'Milestones',
        'middleware' => 'can:view,project',
    ], function () {
        Route::post('', 'Store');
        Route::get('', 'Get');
    });

    Route::group([
        'prefix' => '{project}/users',
        'namespace' => 'Users',
        'middleware' => 'can:view,project',
    ], function () {
        // Route::post('', 'Store');
        Route::get('', 'Get');
    });

    Route::group([
        'prefix' => '{project}/categories',
        'namespace' => 'Categories',
        'middleware' => 'can:view,project',
    ], function () {
        Route::post('', 'Store');
        Route::get('', 'Get');
    });
});
