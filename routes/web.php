<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MechanicController;


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

        //customer signup
     Route::get('user/signup', [UserController::class, 'getSignup'])->name('user.signup');
     Route::post('signup', [UserController::class, 'postSignup'])->name('user.signups');

     //mechanic signup
     Route::get('user/msignup', [UserController::class, 'MechanicSignup'])->name('user.msignup');
     Route::post('msignup', [UserController::class, 'postMechanic'])->name('user.msignups');


     Route::get('signin', [UserController::class, 'getSignin'])->name('user.signin');

     Route::post('login', [LoginController::class, 'postSignin'])->name('user.signins');
         });
});



//Customer Route Group
Route::group(['middleware' => 'role:customer'], function() {

    Route::get('profile', [UserController::class, 'getProfile'])->name('user.profile');



    Route::put('/customers/{id}/update', [CustomerController::class, 'update'])->name('customers.update');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');


    });


//Mechanic Route Group
Route::group(['middleware' => 'role:mechanic'], function() {

    Route::get('mprofile', [UserController::class, 'getMprofile'])->name('user.mprofile');
   
    Route::put('/mechanics/{id}/update', [MechanicController::class, 'update'])->name('mechanics.update');
    Route::get('/mechanics/{id}/edit', [MechanicController::class, 'edit'])->name('mechanics.edit');

    });



//Admin Route Group
Route::group(['middleware' => 'role:admin'], function() {

   

    });



     Route::get('logout', [LoginController::class, 'logout'])->name('user.logout');


