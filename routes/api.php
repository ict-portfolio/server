<?php

use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', [UserController::class , 'show']);
Route::post('/register' , [UserController::class , 'register'])->name('register');
Route::post('/login' , [UserController::class , 'login'])->name('login');

Route::get('/get-sliders',[ClientController::class,'getSliders']);
Route::get('/get-categories',[ClientController::class,'getCategories']);
Route::get('/get-contents-by-category/{category}' , [ClientController::class , 'contentsByCategory']);

Route::get('/get-contents',[ClientController::class,'getContents']);
Route::get('/get-limited-contents',[ClientController::class,'getLimitedContents']);
Route::get('/get-contents/{content}' , [ClientController::class , 'getContent']);

Route::get('/get-services',[ClientController::class,'getServices']);
Route::get('/get-limited-services',[ClientController::class,'getLimitedServices']);
Route::get('/get-services/{service}' , [ClientController::class , 'getService']);
Route::get('/roadmap' , [ClientController::class , 'getFullRoadmap']);
Route::get('/roadmap/{id}' , [ClientController::class , 'getRoadmap']);

Route::post('/contact' , [ContactController::class , 'store']);

Route::get('/get-latest-products',[ProductController::class,'getLatestProducts']);
Route::get('/get-detail-products/{slug}',[ProductController::class,'productDetails']);
Route::get('/related-products/{category_id}',[ProductController::class,'relatedProducts']);


Route::get('/get-latest-services',[ServiceController::class,'getLatestServices']);
Route::get('/get-detail-services/{slug}',[ServiceController::class,'serviceDetails']);
Route::get('/related-services/{category_id}',[ServiceController::class,'relatedServices']);

