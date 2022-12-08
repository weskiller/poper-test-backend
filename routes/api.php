<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
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

Route::any('login', [AuthController::class, 'login'])->name('login');

Route::any('refresh_token', [AuthController::class, 'refresh'])->name('refresh');

Route::any('revoke_token', [AuthController::class, 'revoke'])->name('revoke');

Route::any('validate_token', [AuthController::class, 'validate'])->name('validate');

Route::any('teacher/register', [TeacherController::class, 'register'])->name('teacher.register');

Route::group(['middleware' => 'auth:teacher'], static function () {
    Route::get('school', [SchoolController::class, 'index'])->name('school.index');
    Route::post('school', [SchoolController::class, 'store'])->name('school.store');

    Route::post('invite', [InviteController::class, 'store'])->name('invite.store');
    Route::post('invite/accept', [InviteController::class, 'accept'])->name('invite.accept');


    Route::get('/school/student', [StudentController::class, 'index'])->name('student.index');
    Route::post('/school/student', [StudentController::class, 'store'])->name('student.store');

    Route::get('followers', [TeacherController::class, 'followers'])->name('teacher.followers');

});

Route::group(['middleware' => 'auth:student'], static function () {
    Route::match(['POST', 'DELETE'], 'teacher/{id}/follow', [StudentController::class, 'follow'])->name('student.follow.teacher');
});

