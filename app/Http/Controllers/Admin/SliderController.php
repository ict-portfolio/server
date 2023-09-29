<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends ResponseController
{
    public function index()
    {
        return $this->success(SliderResource::collection(Slider::with('image')->get()),"slider datas");
    }
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(),[
            "image_id" => "required",
            "status" => "required"
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors(),"Validation failed",422);
        }
        $data = new Slider([
            "image_id" => $request->image_id,
            "status" => $request->status
        ]);
        $data->save();
        return $this->success($data,"successfully created the slider",201);
    }
    public function show($id)
    {
        $data = Slider::where('id',$id)->with('image')->first();
        if($data) {
            return $this->success(new SliderResource($data),"detail slider");
        }else {
            return $this->fail(["message" => "slider doesn't exist"],"Not Found",404);
        }
    }
    public function update(Request $request,$id)
    {
        $data = Slider::where('id',$id)->first();
        if($data) {
            $validator = Validator::make(request()->all(),[
                "image_id" => "required",
                "status" => "required"
            ]);
            if($validator->fails()){
                return $this->fail($validator->errors(),"Validation failed",422);
            }
            $data->update([
                "image_id" => $request->image_id,
                "status" => $request->status
            ]);
            return $this->success($data,"successfully created the slider");
        }else {
            return $this->fail(["message" => "slider doesn't exist"],"Not Found",404);
        }
    }
}
