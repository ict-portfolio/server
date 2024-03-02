<?php

namespace App\Http\Controllers\Client;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Http\Controllers\ResponseController;

class AppointmentController extends ResponseController
{
    public function store(AppointmentRequest $request)
    {
        $appointement = Appointment::create($request->validated());
        return $this->success(new AppointmentResource($appointement),"created appointement",201);
    }
}
