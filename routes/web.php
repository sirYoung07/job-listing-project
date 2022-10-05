<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
use GuzzleHttp\Middleware;
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
Route::get('/', [ListingController::class, 'showAll']);

Route::post('/create' , [ListingController::class, 'store'])->middleware('auth');

Route::get('/create' , [ListingController::class, 'create'])->middleware('auth');

Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

Route::delete('/listings/{listing}', [ListingController::class, 'delete'])->middleware('auth');

Route::get('/listings/{listing}', [ListingController::class, 'showSingle']);

Route::get('/manage', [ListingController::class, 'showManage'])->middleware('auth');

Route::post('/users', [UserController::class, 'store']); 
Route::get('/register', [UserController::class, 'showRegisterForm'])->middleware('guest');

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login')->middleware('guest');

Route::post('/user/authenticate', [UserController::class, 'authenticate']);







