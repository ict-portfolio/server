<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Http\Controllers\ResponseController;
use Symfony\Component\HttpKernel\DependencyInjection\ServicesResetter;

class ServiceController extends ResponseController
{
    public function index()
    {
        // return $this->success(ServiceResource::collection(Service::with('image')->get()), "all servies");
        $services = Service::with('image','category')->latest()->paginate(10);
        $paginationData = [
            'current_page' => $services->currentPage(),
            'last_page' => $services->lastPage(),
        ];
        return $this->success(['services' => ServiceResource::collection($services) , 'pagination' => $paginationData], 'fetched all services', 200);
    }
    public function store(ServiceRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $service = Service::create($data);
        return $this->success($service, "Created service", 201);
    }
    public function show($id)
    {
        $service = Service::where('id', $id)->with('image','category')->first();
        if ($service) {
            return $this->success(new ServiceResource($service), "show detail");
        } else {
            return $this->fail(["message" => "service not found"], "not found", 404);
        }
    }
    public function update(ServiceRequest $request, $id)
    {
        $service = Service::where('id', $id)->first();
        if ($service) {
            $data = $request->validated();
            $data['slug'] = Str::slug($request->name);
            $service->update($data);
            return $this->success($service, "updated the service");
        } else {
            return $this->fail(["message" => "service doesn't exist"], "not found", 404);
        }
    }
    public function destroy($id)
    {
        $service = Service::where('id', $id)->first();
        if ($service) {
            $service->delete();
            return $this->success([], "serivce deleted");
        } else {
            return $this->fail(["message" => "service doesn't exist"], "not found", 404);
        }
    }
}
