<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use App\Models\Service;
use Illuminate\Support\Str;
use App\Models\ServiceImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Http\Controllers\ResponseController;
use Symfony\Component\HttpKernel\DependencyInjection\ServicesResetter;

class ServiceController extends ResponseController
{
    protected function serviceImageStore($images,$service_id)
    {
        foreach($images as $image) {
            $serviceImage = new ServiceImage();
            $serviceImage->service_id = $service_id;
            $serviceImage->image_id = $image;
            $serviceImage->save();
        }
    }

    protected function serviceImageDelete($service)
    {
        $existProductImage = ServiceImage::where('service_id',$service);
        if($existProductImage) {
            $existProductImage->delete();
        }
    }

    public function index()
    {
        return $this->success(ServiceResource::collection(Service::all()), 'all services', 200);
    }
    public function store(ServiceRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->name);
        $data['default_image'] = Image::where('id',$request->images[0])->first('url')['url'];
        unset($data["images"]);
        $service = Service::create($data);
        $this->serviceImageStore($request->images,$service->id);
        return $this->success($service, "Created service", 201);
    }
    public function show($id)
    {
        $service = Service::where('id', $id)->with('images.image','category')->first();
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
            $data['default_image'] = Image::where('id',$request->images[0])->first('url')['url'];
            unset($data['images']);
            $service->update($data);
            $this->serviceImageDelete($service->id);
            $this->serviceImageStore($request->images,$service->id);
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
