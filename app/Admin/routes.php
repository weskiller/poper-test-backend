<?php

use App\Admin\Controllers\SchoolController;
use App\Admin\Controllers\StudentController;
use App\Admin\Controllers\TeacherController;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
    'as' => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('school', SchoolController::class);
    $router->resource('teacher', TeacherController::class);
    $router->resource('student', StudentController::class);
});
