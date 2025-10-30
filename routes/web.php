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
        Route::get('list', 'TicketController@list');
        Route::get('assign', 'TicketController@assign');
        Route::get('details/{id}','TicketController@show');

        Route::post('store', 'TicketController@store');
        Route::post('update/{id}', 'TicketController@update');
        Route::post('upload_image','TicketController@uploadImage');
        Route::post('acknowledgement/{id}', 'TicketController@acknowledgement');
        Route::post('comment/{id}', 'TicketController@comment');
        Route::post('get_comment','TicketController@getComment');
        Route::post('delete_comment/{id}','TicketController@deleteComment');
    });

    // Settings
    // Ticketing Comments
    Route::get('ticketing_comments','TicketingCommentController@index');
    Route::prefix('ticketing_comments')->group(function() {
        Route::post('store','TicketingCommentController@store');
        Route::post('update/{id}','TicketingCommentController@update');
        Route::post('deactive/{id}', 'TicketingCommentController@deactive');
        Route::post('active/{id}', 'TicketingCommentController@active');
    });

    // Ticketing Comments
    Route::get('ticketing_types','TicketingTypeController@index');
    Route::prefix('ticketing_types')->group(function() {
        Route::post('store','TicketingTypeController@store');
        Route::post('update/{id}','TicketingTypeController@update');
        Route::post('deactive/{id}', 'TicketingTypeController@deactive');
        Route::post('active/{id}', 'TicketingTypeController@active');
    });
});
