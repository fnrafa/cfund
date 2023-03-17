<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserActionController;
use App\Http\Controllers\UserController;
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
*/


//register
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/otp', [RegisterController::class, 'otp']);

//login
Route::post('/login', [LoginController::class, 'login']);

//lupapassword
Route::post('/reset', 'ForgotPasswordController@sendResetLinkEmail');
Route::post('/resetotp', 'ForgotPasswordController@otp');
Route::post('/resetpassword', 'ForgotPasswordController@reset');

//Guest Routes
Route::get('/', [GuestController::class, 'welcome']);
Route::get('/landing', [GuestController::class, 'landing']);
Route::get('/about', [GuestController::class, 'about']);
Route::get('/help', [GuestController::class, 'help']);

//rute register Company
Route::post('/company/register', 'RegistercompanyController@register');

//rute login Company
Route::post('/company/login', 'LogincompanyController@login');

Route::middleware(['auth.jwt'])->group(function () {
    //User Routes
    Route::get('/user', [UserController::class, 'home']);
    Route::get('/user/logout', [LogoutController::class, 'user']);
    Route::get('/user/help', [UserController::class, 'help']);

    //profile
    Route::get('/user/profile', [UserController::class, 'profile']);

    Route::post('/user/profile/update', [UserActionController::class, 'profileUpdate']);
    Route::post('/user/avatar/upload', [UserActionController::class, 'updateAvatar']);
    Route::post('/user/avatar/delete', [UserActionController::class, 'deleteAvatar']);
    Route::post('/user/payment', [UserActionController::class, 'paymentMethod']);

    //history
    Route::get('/user/history', [UserController::class, 'history']);
    Route::get('/user/history/selection', [UserController::class, 'historySelection']);
    Route::get('/user/history/accepted', [UserController::class, 'historyAccepted']);
    Route::get('/user/history/rejected', [UserController::class, 'historyRejected']);
    Route::get('/user/history/success', [UserController::class, 'historySuccess']);

    //program action
    Route::post('/user/upload/kontrak', [UserActionController::class, 'uploadContract']);
    Route::post('/user/upload/summary', [UserActionController::class, 'uploadSummary']);

    //program
    Route::get('/user/program', [UserController::class, 'program']);
    Route::post('/user/participate', [UserActionController::class, 'participate']);

    //Perusahaan Routes
    //home
    Route::get('/company', 'CompanyController@index');
    Route::get('/company/logout', 'LogoutController@company');

    //show program and editing
    Route::get('/company/program', 'ProgramCompanyController@index')->name('company.program');
    Route::post('/company/program/status', 'ProgramCompanyController@updateStatus')->name('companyprogram.status');
    Route::post('/company/program/delete', 'ProgramCompanyController@delete')->name('companyprogram.delete');
    Route::post('/company/program/insert', 'ProgramCompanyController@insert')->name('companyprogram.participate');

    //show participant and editing
    Route::get('/company/participant', 'ParticipantController@index')->name('company.participant');
    Route::post('/company/participant/update', 'ParticipantController@update')->name('companyparticipant.update');

    //show financial particantp and editing
    Route::get('/company/financing', 'FinancingController@index');
    Route::post('/company/financing/detail', 'FinancingController@detail');
    Route::post('/company/payment', 'FinancingController@payment');
    //Route::post('/company/financing/update', 'FinancingController@update')->name('companyfinancing.update');

    //company profile editing
    Route::get('/company/profile', 'CompanyProfileController@index')->name('company.profile');
    Route::post('/company/profile/update', 'CompanyProfileController@update')->name('companyprofile.update');
});
