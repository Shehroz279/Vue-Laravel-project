<?php

use App\Http\Controllers\AuthControlelr;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\userController;
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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['middleware'=> 'auth'], function (){
    Route::get('/', function (){
        return view('welcome');
    });
    Route::get('/logout', [AuthController::class,'logout'])->name('logout');
    // Route::get('/user', [userController::class,'index']);
});

Route::group(['middleware'=> 'guest'], function (){
    Route::get('/register', function (){
        return view('auth.register');
    });
    Route::get('/login', function (){
        return view('auth.login');
    });
    // Route::post('/register', [AuthController::class,'register'])->name('registration');
    // Route::post('/login', [AuthController::class,'login'])->name('login');
});

// Route::get('/category', [CategoryController::class,'index']);
