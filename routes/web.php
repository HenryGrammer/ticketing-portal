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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function() {
    
    Route::get('/home', 'HomeController@index')->name('home');

    // Users
    Route::get('users','UserController@index');
    Route::prefix('users')->group(function() {
        Route::post('store', 'UserController@store');
        Route::post('update/{id}', 'UserController@update');
        Route::post('deactive/{id}', 'UserController@deactive');
        Route::post('active/{id}', 'UserController@active');
        Route::post('password/{id}','UserController@password');
    });

    // Companies
    Route::get('companies','CompanyController@index');
    Route::prefix('companies')->group(function() {
        Route::post('store', 'CompanyController@store');
        Route::post('update/{id}', 'CompanyController@update');
        Route::post('deactive/{id}', 'CompanyController@deactive');
        Route::post('active/{id}', 'CompanyController@active');
    });

    // Departments
    Route::get('departments','DepartmentController@index');
    Route::prefix('departments')->group(function() {
        Route::post('store', 'DepartmentController@store');
        Route::post('update/{id}', 'DepartmentController@update');
        Route::post('deactive/{id}', 'DepartmentController@deactive');
        Route::post('active/{id}', 'DepartmentController@active');
    });

    // Roles
    Route::get('roles','RoleController@index');
    Route::prefix('roles')->group(function() {
        Route::post('store', 'RoleController@store');
        Route::post('update/{id}', 'RoleController@update');
        Route::post('deactive/{id}', 'RoleController@deactive');
        Route::post('active/{id}', 'RoleController@active');
    });

    // Tickets
    Route::get('tickets','TicketController@index');
    Route::prefix('tickets')->group(function() {
        Route::post('store', 'TicketController@store');
        Route::post('update/{id}', 'TicketController@update');
        Route::post('upload_image','TicketController@uploadImage');
        Route::get('list', 'TicketController@list');
    });
});
