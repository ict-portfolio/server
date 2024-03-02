<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ContentController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\ServiceController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\AppointmentController;

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

Route::get('/roadmap' , [ClientController::class , 'getFullRoadmap']);
Route::get('/roadmap/{id}' , [ClientController::class , 'getRoadmap']);

Route::post('/contact' , [ContactController::class , 'store']);

Route::get('/products',[ProductController::class,'getLatestProducts']);
Route::get('/products/{slug}',[ProductController::class,'productDetails']);
Route::get('/related-products/{product_id}/{category_id}/',[ProductController::class,'relatedProducts']);

Route::get('/contents',[ContentController::class,'getLatestContents']);
Route::get('/contents/{slug}',[ContentController::class,'contentDetails']);
Route::get('/related-contents/{content_id}/{category_id}',[ContentController::class,'relatedContents']);

Route::get('/services',[ServiceController::class,'getLatestServices']);
Route::get('/services/{slug}',[ServiceController::class,'serviceDetails']);
Route::get('/related-services/{service_id}/{category_id}',[ServiceController::class,'relatedServices']);

Route::get('/root-categories' , [CategoryController::class , 'getRootCategories']);
Route::get('/category/{slug}', [CategoryController::class , 'getProductOrServiceOfCategory']);
Route::get('/categories-by-type/{type}' , [CategoryController::class , 'getCategoriesByType']);

Route::get('/search' , [ClientController::class , 'search']);
Route::post('/appointments',[AppointmentController::class, 'store'])->middleware('auth:sanctum');
