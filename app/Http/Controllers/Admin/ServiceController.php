<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Requests\ServiceRequest;

class ServiceController extends ResponseController
{
    public function index()
    {
        return "kjdfk";
    }
    public function store(ServiceRequest $request)
    {
        $data = $request->validated();
        $service = new Service($data);
        $service->save();
        return $this->success($service, "Created service",201);
    }
    public function show($id)
    {
        $service = Service::where('id',$id)->with('image')->first();
        if($service) {
            return $this->success($service,"show detail");
        }else {
            return $this->fail(["message" => "service not found"],"not found",404);
        }
    }
    public function update(ServiceRequest $request, $id)
    {
        $service = Service::where('id',$id)->first();
        if($service) {
            $data = $request->validated();
            $service->update($data);
            return $this->success($service,"updated the service");
        }else {
            return $this->fail(["message" => "service doesn't exist"],"not found",404);
        }
    }
    public function destory($id)
    {
        $service = Service::where('id',$id)->first();
        if($service) {
            $service->delete();
            return $this->success([],"serivce deleted");
        }else {
            return $this->fail(["message" => "service doesn't exist"], "not found",404);
        }
    }
}
