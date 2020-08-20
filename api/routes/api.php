<?php

use App\Enums\RouteGuards;
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

// Authentication module routes
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'Auth\AuthController@login');
    Route::post('register', 'Auth\AuthController@register');

    Route::group([
      'middleware' => [RouteGuards::Authenticated]
    ], function() {
        Route::post('update', 'Auth\AuthController@update');
        Route::put('update-password', 'Auth\AuthController@updatePassword');
        Route::get('logout', 'Auth\AuthController@logout');
        Route::get('user', 'Auth\AuthController@user');
    });
});

// user has to be authenticated to access these routes.
Route::group([
    'middleware' => [RouteGuards::Authenticated]
], function () {
    /**
     * The admin role can only access these routes.
     *
     * @role admin
     */
    Route::group([
        'middleware' => [RouteGuards::SuperAdminOrAdministrator]
    ], function () {
        // User module
        Route::apiResource('users', 'User\UserController');
        Route::put('users-password/{id}', 'User\UserPasswordController@update');
        Route::post('users-avatar/{id}', 'User\UserAvatarController@update');
        Route::group([
            'prefix' => 'archive',
        ], function () {
            Route::apiResource('users', 'User\ArchiveUserController')
                ->except([ 'store', 'update', 'show' ]);
            Route::get('users/{id}/restore', 'User\ArchiveUserController@restore');
        });
    });
});

Route::apiResource('surveys', Survey\SurveyController::class);
