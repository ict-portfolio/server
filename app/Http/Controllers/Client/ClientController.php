<?php

namespace App\Http\Controllers\Client;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ContentResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SliderResource;
use App\Models\Category;
use App\Models\Content;
use App\Models\Service;

class ClientController extends ResponseController
{
    public function getSliders()
    {
        return $this->success(SliderResource::collection(Slider::where('status' , true)->with('image')->get()),"get sliders for client");
    }

    public function getContents()
    {
        $contents = Content::where('status' , true)->with(['image','category'])->latest()->paginate(6);
        $paginationData = [
            'current_page' => $contents->currentPage(),
            'last_page' => $contents->lastPage(),
        ];
        return $this->success(['contents' => ContentResource::collection($contents) , 'pagination' => $paginationData], 'fetched all contents', 200);
    }

    public function getlimitedContents()
    {
        return $this->success(ContentResource::collection(Content::where('status' , true)->with(['image','category'])->latest()->paginate(6)),"get contents for client");
    }

    public function getCategories()
    {
        return $this->success(CategoryResource::collection(Category::with('image')->get()),"get categories for client");
    }

    public function getServices()
    {
        $services = Service::with('image')->latest()->paginate(6);
        $paginationData = [
            'current_page' => $services->currentPage(),
            'last_page' => $services->lastPage(),
        ];
        return $this->success(['services' => ServiceResource::collection($services) , 'pagination' => $paginationData], 'fetched all services', 200);
    }

    public function getLimitedServices()
    {
        return $this->success(ServiceResource::collection(Service::with('image')->paginate(6)),"get service for client");
    }

    public function getService($service)
    {
        $service = Service::where('slug' , $service)->with('image')->first();
        if ($service) {
            return $this->success(new ServiceResource($service) , 'Fetched Service' , 200);
        }
    }

    public function getContent($content)
    {
        $content = Content::where('slug' , $content)->with('image')->with('category')->first();
        if ($content) {
            return $this->success(new ContentResource($content) , 'Fetched content' , 200);
        }
    }

    public function contentsByCategory($category)
    {
        $category = Category::where('slug' , $category)->first();
        $contents = Content::where('category_id' , $category->id)->with('image')->get();
        $data = [
            "category" => $category,
            "contents" => ContentResource::collection($contents)
        ];
        return $this->success($data , "Contents By Category" , 200);
    }
}
