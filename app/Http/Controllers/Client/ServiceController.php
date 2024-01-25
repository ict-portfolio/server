<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends ResponseController
{
    public function getLatestServices(){
        $service = Service::latest()->paginate(3);
        $data=ServiceResource::collection($service);
        return $this->success($data,'latest services');
    }

    public function serviceDetails($slug)
    {
        $service = Service::where('slug', $slug)->first();
        if ($service) {
            return $this->success(new ServiceResource($service), "show detail");
        } else {
            return $this->fail(["message" => "service not found"], "not found", 404);
        }
    }

    public function relatedServices($category_id)
    {
        $service = Service::where('category_id', $category_id)->first();
        if ($service) {
            return $this->success(new ServiceResource($service), "show detail");
        } else {
            return $this->fail(["message" => "service not found"], "not found", 404);
        }
    }
}
