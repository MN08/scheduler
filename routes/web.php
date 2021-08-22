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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', 'App\Http\Controllers\Dashboard\DashboardController@index')->name('dashboard');


    //users
    Route::get('/dashboard/users', 'App\Http\Controllers\Dashboard\UserController@index')->name('dashboard.users');
    Route::get('/dashboard/users/{id}', 'App\Http\Controllers\Dashboard\UserController@edit')->name('dashboard.users.edit');
    Route::put('/dashboard/users/{id}', 'App\Http\Controllers\Dashboard\UserController@update')->name('dashboard.users.update');
    Route::delete('/dashboard/users/{id}', 'App\Http\Controllers\Dashboard\UserController@destroy')->name('dashboard.users.delete');

    //rooms
    Route::get('/dashboard/classes', 'App\Http\Controllers\Dashboard\RoomController@index')->name('dashboard.rooms');
    Route::get('/dashboard/classes/create', 'App\Http\Controllers\Dashboard\RoomController@create')->name('dashboard.rooms.create');
    Route::post('/dashboard/classes', 'App\Http\Controllers\Dashboard\RoomController@store')->name('dashboard.rooms.store');
    Route::get('/dashboard/classes/{id}', 'App\Http\Controllers\Dashboard\RoomController@edit')->name('dashboard.rooms.edit');
    Route::put('/dashboard/classes/{id}', 'App\Http\Controllers\Dashboard\RoomController@update')->name('dashboard.rooms.update');
    Route::delete('/dashboard/classes/{id}', 'App\Http\Controllers\Dashboard\RoomController@destroy')->name('dashboard.rooms.delete');

    //teachers
    Route::get('/dashboard/teachers', 'App\Http\Controllers\Dashboard\teacherController@index')->name('dashboard.teachers');
    Route::get('/dashboard/teachers/create', 'App\Http\Controllers\Dashboard\TeacherController@create')->name('dashboard.teachers.create');
    Route::post('/dashboard/teachers', 'App\Http\Controllers\Dashboard\TeacherController@store')->name('dashboard.teachers.store');
    Route::get('/dashboard/teachers/{id}', 'App\Http\Controllers\Dashboard\teacherController@edit')->name('dashboard.teachers.edit');
    Route::put('/dashboard/teachers/{id}', 'App\Http\Controllers\Dashboard\teacherController@update')->name('dashboard.teachers.update');
    Route::delete('/dashboard/teachers/{id}', 'App\Http\Controllers\Dashboard\teacherController@destroy')->name('dashboard.teachers.delete');


    //subject
    Route::get('/dashboard/subjects', 'App\Http\Controllers\Dashboard\subjectController@index')->name('dashboard.subjects');
    Route::get('/dashboard/subjects/create', 'App\Http\Controllers\Dashboard\subjectController@create')->name('dashboard.subjects.create');
    Route::post('/dashboard/subjects', 'App\Http\Controllers\Dashboard\subjectController@store')->name('dashboard.subjects.store');
    Route::get('/dashboard/subjects/{id}', 'App\Http\Controllers\Dashboard\subjectController@edit')->name('dashboard.subjects.edit');
    Route::put('/dashboard/subjects/{id}', 'App\Http\Controllers\Dashboard\subjectController@update')->name('dashboard.subjects.update');
    Route::delete('/dashboard/subjects/{id}', 'App\Http\Controllers\Dashboard\subjectController@destroy')->name('dashboard.subjects.delete');


    //time
    Route::get('/dashboard/times', 'App\Http\Controllers\Dashboard\timeController@index')->name('dashboard.times');
    Route::get('/dashboard/times/create', 'App\Http\Controllers\Dashboard\timeController@create')->name('dashboard.times.create');
    Route::post('/dashboard/times', 'App\Http\Controllers\Dashboard\timeController@store')->name('dashboard.times.store');
    Route::get('/dashboard/times/{id}', 'App\Http\Controllers\Dashboard\timeController@edit')->name('dashboard.times.edit');
    Route::put('/dashboard/times/{id}', 'App\Http\Controllers\Dashboard\timeController@update')->name('dashboard.times.update');
    Route::delete('/dashboard/times/{id}', 'App\Http\Controllers\Dashboard\timeController@destroy')->name('dashboard.times.delete');

    //School Year
    Route::get('/dashboard/schoolyears', 'App\Http\Controllers\Dashboard\schoolyearController@index')->name('dashboard.schoolyears');
    Route::get('/dashboard/schoolyears/create', 'App\Http\Controllers\Dashboard\schoolyearController@create')->name('dashboard.schoolyears.create');
    Route::post('/dashboard/schoolyears', 'App\Http\Controllers\Dashboard\schoolyearController@store')->name('dashboard.schoolyears.store');
    Route::get('/dashboard/schoolyears/{id}', 'App\Http\Controllers\Dashboard\schoolyearController@edit')->name('dashboard.schoolyears.edit');
    Route::put('/dashboard/schoolyears/{id}', 'App\Http\Controllers\Dashboard\schoolyearController@update')->name('dashboard.schoolyears.update');
    Route::delete('/dashboard/schoolyears/{id}', 'App\Http\Controllers\Dashboard\schoolyearController@destroy')->name('dashboard.schoolyears.delete');
});



require __DIR__ . '/auth.php';
