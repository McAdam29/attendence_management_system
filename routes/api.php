<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Application\UserModule\Controller\UserController;
use Application\Attendence\Controller\AttendenceController;
use Application\StudentModule\Controller\StudentController;

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

// Route::group([
//     'prefix' => 'user'
// ], function () {
//     Route::post('register', [UserController::class,'registerNewUser']);
//     Route::post('login', [UserController::class, 'login']);
//     Route::post('logout', [UserController::class, 'logout'])->middleware('custom_auth'); // Assuming 'custom_auth' is a middleware for authentication
// });


// Route::group([
//     'prefix' => 'students',
//     'middleware' => 'custom_auth'
// ], function () {
//     Route::post('add', [StudentController::class,'addStudent']);
//     Route::get('getAll', [StudentController::class, 'getAllStudents']);
//     Route::get('getById/{id}', [StudentController::class, 'getStudentById']);
//     Route::post('update', [StudentController::class, 'updateStudent']);
//     Route::post('delete', [StudentController::class, 'deleteStudent']);
// });


Route::group(['prefix' => 'attendence'], function () {
    Route::post('markBulkAttendence', [AttendenceController::class, 'markBulkAttendence']);
    Route::get('getAllStudentsAttendence', [AttendenceController::class, 'getAllStudentsAttendence']);
   Route::post('markAttendence', [AttendenceController::class, 'markAttendence']);
});
