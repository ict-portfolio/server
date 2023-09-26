<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ResponseController
{
    public function index()
    {
        return $this->success(CategoryResource::collection(Category::with('image')->get()),"category datas");
    }
    public function store()
    {
        $validator = Validator::make(Request()->all(),[
            "name" => "required|min:3|unique:categories,name",
            "image_id" => "required"
        ]);
        if($validator->fails()) {
            return $this->fail($validator->errors(),"Validation Fail",422);
        }
        $data = new Category([
            'name' => Request('name'),
            'image_id' => Request('image_id'),
            'slug'=> Str::slug(Request('name'))
        ]);
        $data->save();
        return $this->success($data,"Successfully Created the ".$data->name,201);
    }
    public function show($slug)
    {
        $data = Category::where('slug',$slug)->with('image')->first();
        if($data) {
            return $this->success(new CategoryResource($data),"detail of ".$data->name);
        }else {
            return $this->fail(["message" => "Category doesn't exist"],"Not Found",404);
        }
    }
    public function update($slug)
    {
        $data = Category::where('slug',$slug)->first();
        if($data) {
            $validator = Validator::make(Request()->all(),[
                "name" => "required|min:3|unique:categories,name",
                "image_id" => "required"
            ]);
            if($validator->fails()) {
                return $this->fail($validator->errors(),"Validation Fail",422);
            }
            $data->update([
                'name' => Request('name'),
                'image_id' => Request('image_id'),
                'slug'=> Str::slug(Request('name'))
            ]);
            return $this->success(new CategoryResource($data),"successfully updated the ".$data->name);
        }else {
            return $this->fail(["message" => "Category doesn't exist"],"Not Found",404);
        }
    }
}
