<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends ResponseController
{
    public function index()
    {
        return $this->success(TagResource::collection(Tag::all()),"tag datas");
    }
    public function store()
    {
        $validator = Validator::make(request()->all(),[
            "name" => "required"
        ]);
        if($validator->fails()) {
            return $this->fail($validator->errors(),"Validation failed",422);
        }
        $data = new Tag(request(["name"]));
        $data->save();
        return $this->success($data,"successfully created the tag",201);
    }
    public function show($id)
    {
        $data = Tag::where('id',$id)->first();
        if($data) {
            return $this->success(new TagResource($data),"detail tag");
        }else {
            return $this->fail(["message" => "tag doesn't exist"],"Not Found",404);
        }
    }
    public function update($id)
    {
        $data = Tag::where('id',$id)->first();
        if($data) {
            $validator = Validator::make(request()->all(),[
                "name" => "required"
            ]);
            if($validator->fails()) {
                return $this->fail($validator->errors(),"Validation failed",422);
            }
            $data->update(request(["name"]));
            return $this->success(new TagResource($data),"Updated the tag");
        }else {
            return $this->fail(["message" => "tag doesn't exist"],"Not Found",404);
        }
    }
}
