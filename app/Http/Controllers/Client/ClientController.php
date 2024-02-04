<?php

namespace App\Http\Controllers\Client;

use App\Models\Slider;
use App\Models\Content;
use App\Models\Roadmap;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;
use App\Http\Resources\ContentResource;
use App\Http\Resources\RoadmapResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\CategoryResource;
use App\Http\Controllers\ResponseController;
use App\Models\RootCategory;

class ClientController extends ResponseController
{
    public function getSliders()
    {
        return $this->success(SliderResource::collection(Slider::where('status' , true)->with('image')->get()),"get sliders for client");
    }

    public function getRootCategories()
    {
        $rootCategories = RootCategory::with('categories')->get();
        return $this->success($rootCategories , "all categories" , 200);
    }

    public function getCategories()
    {
        return $this->success(CategoryResource::collection(Category::with('image')->get()),"get categories for client");
    }

    public function getFullRoadmap()
    {
        return $this->success(RoadmapResource::collection(Roadmap::latest()->get()),"ict roadmap");
    }

    public function getRoadmap($id)
    {
        $map = Roadmap::find($id);
        if ($map) {
            return $this->success(new RoadmapResource($map) , "roadmap" , 200);
        } else {
            return $this->fail([] , "Not Found!" , 404);
        }
    }
}
