<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\RootCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ResponseController;

class RootCategoryController extends ResponseController
{
    public function index()
    {
        return $this->success(RootCategory::all(),"category datas");
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(),[
            "name" => "required|min:3|unique:root_categories,name",
            "icon" => "required",
        ]);
        if($validator->fails()) {
            return $this->fail($validator->errors(),"Validation Fail",422);
        }
        $localhostName = env('APP_URL','http://localhost:8000');
        $icon = $req->file('icon');
        $iconName = time()."_".$icon->getClientOriginalName();
        $icon = $icon->storeAs('icons',$iconName);
        $data = RootCategory::create([
            "name" => $req->name,
            "slug" => Str::slug($req->name),
            "icon" => $localhostName."/storage/".$icon,
        ]);
        return $this->success($data,"Successfully Created the ".$data->name,201);
    }

    public function show($id)
    {
        $data = RootCategory::find($id);
        if($data) {
            return $this->success($data,"detail of ".$data->name);
        }else {
            return $this->fail(["message" => "rootCategory doesn't exist"],"Not Found",404);
        }
    }

    public function destroy($id) {
        $data = RootCategory::find($id);
        if ($data) {
            unlink(public_path(parse_url($data->icon, PHP_URL_PATH)));
            $data->delete();
            return $this->success([] , "Deleted rootCategory successfully" , 200);
        } else {
            return $this->fail([] , "rootCategory Not Found" , 404);
        }
    }
}
