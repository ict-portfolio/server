<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Http\Controllers\ResponseController;

class AppointmentController extends ResponseController
{
    public function index()
    {
        $appointment = Appointment::with('service','user')->get();
        return $this->success(AppointmentResource::collection($appointment),"all appointments");
    }

    public function show($id)
    {
        $appointment = Appointment::with('service','user')->find($id);
        if($appointment) {
            return $this->success(new AppointmentResource($appointment),"detail appointement");
        }else {
            return $this->fail(["message" => "appointment Not Found"],"Not Found",404);
        }
    }

    public function destroy($id) {
    $deleted = Appointment::where('id',$id)->delete();
    if($deleted) {
        return $this->success([],"deleted appoinment");
    }else {
        return $this->fail(["message" => "appointment Not Found"],"Not Found",404);
    }
    }
}
