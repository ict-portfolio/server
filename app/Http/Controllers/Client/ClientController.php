<?php

namespace App\Http\Controllers\Client;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ContentResource;
use App\Http\Resources\SliderResource;
use App\Models\Category;
use App\Models\Content;
use App\Models\Service;

class ClientController extends ResponseController
{
    public function getSliders()
    {
        return $this->success(SliderResource::collection(Slider::with('image')->get()),"get sliders for client");
    }
    public function getContents()
    {
        return $this->success(ContentResource::collection(Content::with(['image','category'])->get()),"get contents for client");
    }
    public function getCategories()
    {
        return $this->success(CategoryResource::collection(Category::with('image')->get()),"get categories for client");
    }
    public function getServices()
    {
        return $this->success(Service::with('image')->get(),"get service for client");
    }
}
