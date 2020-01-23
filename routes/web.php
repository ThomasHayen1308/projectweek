<?php

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

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('users', 'Admin\UserController');
});

// ROUTE TO HOME
Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
Route::view('/', 'home');

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

//  ROUTES TO LOKALEN
Route::view('admin.users.lokalen','/users/lokalen');

//  ROUTES TO USER PROFILE
Route::redirect('users', '/users/profile');
Route::middleware(['auth'])->prefix('users')->group(function () {
    // get route for showing the (update) form
    Route::get('profile', 'User\ProfileController@edit');
    // post route for updating the profile
    Route::post('profile', 'User\ProfileController@update');
    // get for showing form
    Route::get('password', 'User\PasswordController@edit');
    // post for updating the password
    Route::post('password', 'User\PasswordController@update');
});

// USER Controller
Route::resource('users', 'Admin\UserController');
