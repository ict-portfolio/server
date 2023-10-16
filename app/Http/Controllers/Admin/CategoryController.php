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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name" => "required|min:3|unique:categories,name",
            "image_id" => "required"
        ]);
        if($validator->fails()) {
            return $this->fail($validator->errors(),"Validation Fail",422);
        }
        $data = Category::create([
            "name" => $request->name,
            "image_id" => $request->image_id,
            "slug" => Str::slug($request->name),
        ]);
        return $this->success($data,"Successfully Created the ".$data->name,201);
    }
    public function show($id)
    {
        $data = Category::where('id',$id)->with('image')->first();
        if($data) {
            return $this->success(new CategoryResource($data),"detail of ".$data->name);
        }else {
            return $this->fail(["message" => "Category doesn't exist"],"Not Found",404);
        }
    }
    public function update(Request $request, $id)
    {
        $data = Category::where('id',$id)->first();
        if($data) {
            $validator = Validator::make(Request()->all(),[
                "name" => "required|min:3",
                "image_id" => "required"
            ]);
            if($validator->fails()) {
                return $this->fail($validator->errors(),"Validation Fail",422);
            }
            $data->update([
                'name' => $request->name,
                'image_id' => $request->image_id,
                'id'=> Str::slug($request->id)
            ]);
            return $this->success(new CategoryResource($data),"successfully updated the ".$data->name);
        }else {
            return $this->fail(["message" => "Category doesn't exist"],"Not Found",404);
        }
    }

    public function destroy($category) {
        $data = Category::where('id' , $category)->first();
        if ($data) {
            $data->delete();
            return $this->success([] , "Deleted category successfully" , 200);
        } else {
            return $this->fail([] , "Category Not Found" , 404);
        }
    }
}
