<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ResponseController;

class ImageController extends ResponseController
{
    public function index()
    {
        return $this->success(Image::with('slider')->paginate(10) , "All images" , 200);
    }
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(),[
            "url" => "required|mimes:jpg,png,jpeg"
        ]);
        if($validator->fails()) {
            return $this->fail($validator->errors(),"Validation failed",422);
        }
        $localhostName = env("APP_URL","localhost:8000");
        $url = $req->file('url');
        $imageName = time()."_".$url->getClientOriginalName();
        $url->storeAs('images',$imageName);
        $data=new Image();
        $data->url = $localhostName."/storage/".$imageName;
        $data->save();
        return $this->success($data,"Image uploaded successfully.",201);
    }
    public function destroy($id)
    {
        $image = Image::find($id);
        if($image) {
            $slider = Slider::find($id);
            if($slider) {
                $slider->delete();
            }
            $image->delete();
            return $this->success([],"deleted");
        }else {
            return $this->fail(["message" => "image doesn't exist "],"not found",404);
        }
    }
}
