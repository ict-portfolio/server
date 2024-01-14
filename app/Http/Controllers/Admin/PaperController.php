<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Paper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaperController extends ResponseController
{

    public function index()
    {
        return $this->success(Paper::all(),"all papers");
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(),[
            "name" => "required",
            "category_id" => "required",
            "file_id" => "required",
            "image_id" => "required",
            "description"=> "required",
            "downloadable" => "required",
        ]);
        if($validator->fails()) {
            return $this->fail($validator->errors(),"Validation Fail",422);
        }
        $data = Paper::create([
            "name" => $req->name,
            "category_id" => $req->category_id,
            "file_id" => $req->file_id,
            "image_id" => $req->image_id,
            "description" => $req->descripton,
            "downloadable" => $req->downloadable,
            "slug" => Str::slug($req->name),
        ]);
        return $this->success($data,"Successfully Created the ".$data->name,201);

    }

    public function show(string $id)
    {
        $data = Paper::find($id);
        if($data) {
            return $this->success($data,"detail of ".$data->name);
        }else {
            return $this->fail(["message" => "Paper doesn't exist"],"Not Found",404);
        }
    }


    public function update(Request $req, string $id)
    {
        $paper = Paper::find($id);
        if (!$paper) {
            return $this->fail([] , "Not Found!" , 404);
        }
        $validator = Validator::make($req->all(),[
            "name" => "required",
            "category_id" => "required",
            "file_id" => "required",
            "image_id" => "required",
            "description"=> "required",
            "downloadable" => "required",
        ]);
        if($validator->fails()) {
            return $this->fail($validator->errors(),"Validation Fail",422);
        }
        $paper->name = $req->name;
        $paper->category_id = $req->category_id;
        $paper->image_id = $req->image_id;
        $paper->file_id = $req->file_id;
        $paper->description = $req->description;
        $paper->downloadable = $req->downloadable;
        $paper->update();
        return $this->success($paper , 'Successfully updated the paper.' , 200);

    }

    public function destroy(string $id)
    {
        $paper = Paper::find($id);
        if ($paper) {
            $paper->delete();
            return $this->success([] , "Deleted successfully." , 200);
        } else {
            return $this->fail([] , "Not Found!" , 404);
        }
    }
}
