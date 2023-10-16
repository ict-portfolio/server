<?php

use App\Models\Slider;
use App\Models\Content;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;

Route::apiResource('categories',CategoryController::class);
Route::apiResource('images',ImageController::class);
Route::apiResource('contents',ContentController::class);
Route::apiResource('services',ServiceController::class);
Route::apiResource('sliders',SliderController::class);
Route::apiResource('contacts' , ContactController::class);
Route::get('/fake-datas', function () {
    Category::factory()->count(5)->create();
    Content::factory()->count(15)->create();
    Service::factory()->count(15)->create();
    return "success";
});
