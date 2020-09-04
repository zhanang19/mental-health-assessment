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

    // Surveys Module
    Route::apiResource('surveys', 'Survey\SurveyController');
    Route::get('surveys/{slug}/slug', 'Survey\SurveyController@findBySlug');
    Route::get('surveys/{surveyId}/take-survey', 'Survey\SurveyController@takeSurvey')
        ->withoutMiddleware(RouteGuards::SuperAdminOrAdministrator);

    // Survey Response Module
    Route::apiResource('responses', 'SurveyResponse\SurveyResponseController');

    Route::group([
        'middleware' => [RouteGuards::SuperAdminOrAdministrator]
    ], function () {
        // Survey Question Group
        Route::post('surveys/{surveyId}/question-groups', 'Survey\SurveyQuestionGroupController@store');
        Route::get('surveys/{surveyId}/question-groups/{questionGroupId}/duplicate', 'Survey\SurveyQuestionGroupController@duplicate');
        Route::delete('surveys/{surveyId}/question-groups/{questionGroupId}', 'Survey\SurveyQuestionGroupController@destroy');

        // Survey Question
        Route::post('surveys/{surveyId}/question-groups/{questionGroupId}', 'Survey\SurveyQuestionController@store');
        Route::get('surveys/{surveyId}/question-groups/{questionGroupId}/questions/{questionId}/duplicate', 'Survey\SurveyQuestionController@duplicate');
        Route::delete('surveys/{surveyId}/question-groups/{questionGroupId}/questions/{questionId}', 'Survey\SurveyQuestionController@destroy');

        // not available
        Route::group([
            'prefix' => 'archive',
        ], function () {
            Route::apiResource('surveys', 'User\ArchiveUserController')
                ->except([ 'store', 'update', 'show' ]);
            Route::get('surveys/{id}/restore', 'User\ArchiveUserController@restore');
        });
    });
});

