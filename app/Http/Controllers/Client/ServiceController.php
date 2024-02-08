<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends ResponseController
{
    public function getLatestServices(Request $request){
        $services = Service::latest()->paginate($request->input('limit'));
        $paginationData = [
            'current_page' => $services->currentPage(),
            'last_page' => $services->lastPage(),
        ];
        $data=ServiceResource::collection($services);
        return $this->success(['services' => $data , 'meta' => $paginationData],'latest services');
    }

    public function serviceDetails($slug)
    {
        $service = Service::where('slug', $slug)->with('images.image' , 'category')->first();
        if ($service) {
            return $this->success(new ServiceResource($service), "show detail");
        } else {
            return $this->fail(["message" => "service not found"], "not found", 404);
        }
    }

    public function relatedServices($service_id , $category_id)
    {
        $services = Service::where('category_id', $category_id)->where('id', '<>', $service_id)->latest()->paginate(4);
        if ($services) {
            return $this->success(ServiceResource::collection($services), "show detail");
        } else {
            return $this->fail(["message" => "service not found"], "not found", 404);
        }
    }
}
