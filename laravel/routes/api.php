<?php

use App\Http\Controllers\AuthControlelr;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    //logout
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logoutAllDevices', [AuthController::class, 'logoutAllDevices']);
    // users detail
    Route::get('/auth', function () {
        $user=Auth::user();
        return response()->json(['user' => $user]);
    });
    Route::get('/category', [CategoryController::class,'index']);
    Route::get('/category/{id}', [CategoryController::class,'view']);
    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/product/{id}', [ProductController::class, 'view']);
    
});
Route::middleware(['auth:sanctum','ability:role-productOwn,role-admin'])->group(function(){
    Route::post('/product', [ProductController::class, 'create']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'delete']);
    // Route::get('/category/{id}', [CategoryController::class,'view']);
    // Route::get('/category', [CategoryController::class,'index']);
});
Route::middleware(['auth:sanctum','ability:role-categoryOwn,role-admin'])->group(function(){
    Route::put('/category/{id}', [CategoryController::class,'update']);
    Route::delete('/category/{id}', [CategoryController::class,'delete']);
    Route::post('/category', [CategoryController::class,'create']);
    Route::get('/category/count/{id}', [CategoryController::class,'count']); 
    
    // Route::get('/product', [ProductController::class, 'index']);
    // Route::get('/product/{id}', [ProductController::class, 'view']);
});
Route::middleware(['auth:sanctum','ability:role-admin'])->group(function(){
    Route::get('/user', [UserController::class,'index']);
    Route::get('/user/{id}', [UserController::class,'view']);
    Route::put('/user/{id}', [UserController::class,'update']);
    Route::delete('/user/{id}', [UserController::class,'delete']);
});
// //registration
Route::post('/register', [AuthController::class, 'register']);

//login
Route::post('/login', [AuthController::class, 'login']);

Route::post("/resetPassword",[AuthController::class,"resetPassword"])->middleware(['auth:sanctum','ability:authentication']);
//verification
Route::post("/tokenVerfied",[AuthController::class,"tokenVerfied"])->middleware(['auth:sanctum','ability:authentication']);
Route::post("/verificationByEmail",[AuthController::class,"VerificationByEmail"]);