<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
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

    public function store()
    {
        $validator = Validator::make(Request()->all(),[
            "image" => "required|mimes:jpg,png,jpeg"
        ]);
        if($validator->fails()) {
            return $this->fail($validator->errors(),"Validation failed",422);
        }
        $image = Request()->file('image');
        $imageName = time()."_".$image->getClientOriginalName();
        $image->storeAs('images',$imageName);
        $data=new Image();
        $data->image = $imageName;
        $data->save();
        return $this->success($data,"Image uploaded successfully.",201);
    }
}
