<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Application\UserModule\Controller\UserController;
use Application\Attendence\Controller\AttendenceController;

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

Route::group([
    'prefix' => 'user'
], function () {
    Route::post('register', [UserController::class,'registerNewUser']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('logout', [UserController::class, 'logout'])->middleware('custom_auth'); // Assuming 'custom_auth' is a middleware for authentication
});


Route::group([
    'prefix' => 'students',
    'middleware' => 'custom_auth'
], function () {
    Route::post('add', [UserController::class,'registerNewUser']);
    Route::post('update', [UserController::class, 'login']);
    Route::post('delete', [UserController::class, 'logout'])->middleware('custom_auth'); // Assuming 'custom_auth' is a middleware for authentication
});

Route::group(['prefix' => 'attendence', 'middleware' => 'custom_auth'], function () {
    Route::post('markBulkAttendence', [AttendenceController::class, 'markBulkAttendence']);
    Route::get('getAllStudentsAttendence', [AttendenceController::class, 'getAllStudentsAttendence']);
});
