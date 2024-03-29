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

    Route::post('/logout', 'Logout')->middleware('auth');
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
            Route::get('{project}/home', 'Home');
        });

        Route::group([
            'prefix' => '{organization}/users',
            'namespace' => 'Users',
        ], function () {
            Route::get('', 'Get');
        });
    });

    Route::group([
        'middleware' => 'can:edit,organization',
    ], function () {
        Route::put('{organization}', 'Update');

        Route::group([
            'prefix' => '{organization}/projects',
            'namespace' => 'Projects',
            'middleware' => 'can:edit,project',
        ], function () {
            Route::put('{project}', 'Update');
            Route::delete('{project}', 'Delete');
        });
    });

    Route::group([
        'middleware' => 'can:manage,organization',
    ], function () {
        Route::group([
            'prefix' => '{organization}/users',
            'namespace' => 'Users',
        ], function () {
            Route::post('', 'Store');
            Route::put('{organizationPermission}', 'Update');
            Route::delete('{organizationPermission}', 'Delete');
        });
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
        Route::group([
            'prefix' => '{issue}/comments',
            'namespace' => 'Comments',
        ], function () {
            Route::get('', 'Get');
            Route::post('', 'Store');
        });

        Route::get('', 'Get');
        Route::get('{issue}', 'Show');
        Route::post('', 'Store');
        Route::put('{issue}', 'Update');
    });

    Route::group([
        'prefix' => '{project}/milestones',
        'namespace' => 'Milestones',
        'middleware' => 'can:view,project',
    ], function () {
        Route::post('', 'Store');
        Route::get('', 'Get');
        Route::put('{milestone}', 'Update');
        Route::delete('{milestone}', 'Delete');
    });

    Route::group([
        'prefix' => '{project}/users',
        'namespace' => 'Users',
        'middleware' => 'can:view,project',
    ], function () {
        Route::get('', 'Get');
    });

    Route::group([
        'prefix' => '{project}/categories',
        'namespace' => 'Categories',
        'middleware' => 'can:view,project',
    ], function () {
        Route::post('', 'Store');
        Route::get('', 'Get');
        Route::put('{category}', 'Update');
        Route::delete('{category}', 'Delete');
    });

    Route::group([
        'prefix' => '{project}',
        'middleware' => 'can:manage,project',
    ], function () {
        Route::group([
            'prefix' => 'users',
            'namespace' => 'Users',
        ], function () {
            Route::post('', 'Store');
            Route::delete('{projectPermission}', 'Delete');
            Route::put('{projectPermission}', 'Update');
        });
    });
});

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function () {
    Route::group([
        'prefix' => 'organizations',
        'namespace' => 'Organizations',
    ], function () {
        Route::get('', 'Get');
        Route::put('{organization}', 'Update');
    });

    Route::group([
        'prefix' => 'projects',
        'namespace' => 'Projects',
    ], function () {
        Route::get('', 'Get');
        Route::put('{project}', 'Update');
    });

    Route::group([
        'prefix' => 'users',
        'namespace' => 'Users',
    ], function () {
        Route::get('', 'Get');
        Route::put('{user}', 'Update');
    });
});
