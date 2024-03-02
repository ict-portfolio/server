<?php

namespace App\Http\Controllers\Client;

use App\Models\Slider;
use App\Models\Product;
use App\Models\Roadmap;
use App\Models\Category;
use App\Models\RootCategory;
use Illuminate\Http\Request;
use App\Http\Resources\SliderResource;
use App\Http\Resources\RoadmapResource;
use App\Http\Resources\CategoryResource;
use App\Http\Controllers\ResponseController;
use App\Models\Service;

class ClientController extends ResponseController
{
    public function getSliders()
    {
        return $this->success(SliderResource::collection(Slider::where('status' , true)->with('image')->get()),"get sliders for client");
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

    public function search(Request $request)
    {
        $products = Product::where('name' , 'LIKE' , '%' . $request->input('query') . '%')->latest()->get();
        $services = Service::where('name' , 'LIKE' , '%' . $request->input('query') . '%')->latest()->get();
        return $this->success(['products' => $products , 'services' => $services] , 'result' , 200);
    }
}
