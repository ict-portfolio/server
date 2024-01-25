<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\CategoryController;

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

Route::get('/root-categories' , [ClientController::class , 'getRootCategories']);
Route::get('/get-category/{slug}', [CategoryController::class , 'getProductOrServiceOfCategory']);
