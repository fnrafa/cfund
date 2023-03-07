<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|

Route::get('/', function () {
    return view('welcome');
});
*/

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    //rute home
    Route::get('/', 'HomeController@index')->name('user.index');
    Route::get('/company', 'CompanyController@index')->name('company.index');

    Route::get('/forgot-password', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/forgot-password', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/reset-password/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/reset-password', 'ResetPasswordController@reset')->name('password.update');


    Route::group(['middleware' => ['guest']], function () {
        //rute register
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        //rute login
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

        //rute register Company
        Route::get('/company/register', 'RegistercompanyController@show')->name('registercompany.show');
        Route::post('/company/register', 'RegistercompanyController@register')->name('registercompany.perform');

        //rute login Company
        Route::get('/company/login', 'LogincompanyController@show')->name('logincompany.show');
        Route::post('/company/login', 'LogincompanyController@login')->name('logincompany.perform');
    });

    Route::group(['middleware' => ['auth']], function () {
        //rute logout
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
    Route::group(['middleware' => ['auth:company']], function () {
        Route::get('/company/logout', 'LogoutcompanyController@perform')->name('logoutcompany.perform');
    });
});
