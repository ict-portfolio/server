<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\RootCategory;
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
        return $this->success(CategoryResource::collection(Category::with('root_category')->get()),"category datas");
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(),[
            "name" => "required|min:3|unique:categories,name",
            "root_category_id" => "required",
            "icon" => "required",
        ]);
        if($validator->fails()) {
            return $this->fail($validator->errors(),"Validation Fail",422);
        }
        $localhostName = env('APP_URL','http://localhost:8000');
        $icon = $req->file('icon');
        $iconName = time()."_".$icon->getClientOriginalName();
        $icon = $icon->storeAs('icons',$iconName);
        $data = Category::create([
            "name" => $req->name,
            "root_category_id" => $req->root_category_id,
            "slug" => Str::slug($req->name),
            "icon" => $localhostName."/storage/".$icon,
        ]);
        return $this->success(new CategoryResource($data),"Successfully Created the ".$data->name,201);
    }
    public function show($id)
    {
        $data = Category::where('id',$id)->with('root_category')->first();
        if($data) {
            return $this->success(new CategoryResource($data),"detail of ".$data->name);
        }else {
            return $this->fail(["message" => "Category doesn't exist"],"Not Found",404);
        }
    }
    public function destroy($id) {
        $data = Category::find($id);
        if ($data) {
            unlink(public_path(parse_url($data->icon, PHP_URL_PATH)));
            $data->delete();
            return $this->success([] , "Deleted category successfully" , 200);
        } else {
            return $this->fail([] , "Category Not Found" , 404);
        }
    }
    public function getCategoriesByType($type) {
        $rootCategory = RootCategory::where('type',$type)->with('categories')->get();
        $data = [];
        foreach($rootCategory as $c) {
            foreach($c->categories as $d) {
                array_push($data , $d);
            }
        }
        return $data;
        // return $rootCategory;
        // $category = Category::whereIn('id',$rootCategory)->get();
        // return $category;

    }
}
