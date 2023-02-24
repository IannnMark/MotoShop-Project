<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

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

Route::get('/', function () {
    return view('welcome');
});



Route::group(['prefix' => 'user'], function(){

     Route::group(['middleware' => 'guest'], function() {

     Route::get('user/signup', [UserController::class, 'getSignup'])->name('user.signup');

     Route::post('signup', [UserController::class, 'postSignup'])->name('user.signups');

     Route::get('signin', [UserController::class, 'getSignin'])->name('user.signin');

     Route::post('login', [LoginController::class, 'postSignin'])->name('user.signins');

    

         });

});

Route::group(['middleware' => 'role:customer'], function() {

    Route::get('profile', [UserController::class, 'getProfile'])->name('user.profile');
    Route::get('logout', [LoginController::class, 'logout'])->name('user.logout');


    Route::put('/customers/{id}/update', [CustomerController::class, 'update'])->name('customers.update');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');


    });


    Route::group(['middleware' => 'role:admin'], function() {

   

    });


