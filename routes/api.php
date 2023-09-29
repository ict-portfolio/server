<?php

use App\Http\Controllers\Client\ClientController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/get-sliders',[ClientController::class,'getSliders']);
Route::get('/get-contents',[ClientController::class,'getContents']);
Route::get('/get-categories',[ClientController::class,'getCategories']);
Route::get('/get-services',[ClientController::class,'getServices']);
