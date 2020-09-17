<?php

use App\Http\Controllers\User\StudentExportController;
use App\Repository\UserRepositoryInterface;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/exports/students', [StudentExportController::class, 'export']);

Route::get('/testing', function (UserRepositoryInterface $userRepository) {
    return $userRepository->getStudents();
});
