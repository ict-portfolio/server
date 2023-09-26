<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/categories',CategoryController::class);
Route::apiResource('/images',ImageController::class);
Route::apiResource('/contents',ContentController::class);
Route::apiResource('/sliders',SliderController::class);
Route::apiResource('/tags',TagController::class);
