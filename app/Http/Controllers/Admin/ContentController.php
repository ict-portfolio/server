<?php

namespace App\Http\Controllers\Admin;

use App\Models\Content;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContentRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\ContentResource;

class ContentController extends ResponseController
{
    public function index()
    {
        return $this->success(ContentResource::collection(Content::with(['category','image'])->get()),"content datas");
    }
    public function store(ContentRequest $request)
    {
        $content = $request->validated();
        $content['slug'] = Str::slug($request->name);
        $data = new Content($content);
        $data->save();
        return $this->success($data,"Successfully created the {$data->name}",201);
    }
    public function show($id)
    {
        $data = Content::where('id',$id)->with(['category','image'])->first();
        if($data) {
            return $this->success(new ContentResource($data),"detail of {$data->name}");
        }else {
            return $this->fail(["message" => "content doesn't exist",],"Not Found",404);
        }
    }
    public function update(ContentRequest $req,$id)
    {
        $data = Content::where('id',$id)->first();
        if($data) {
            $content = $req->validated();
            $content['slug'] = Str::slug(Request()->name);
            $data->update($content);
            return $this->success($data, "Successfully updated the {$data->name}");
        }else {
            return $this->fail(["message" => "content doesn't exist",],"Not Found",404);
        }
    }
    public function destroy($id)
    {
        $content = Content::where('id',$id)->first();
        if($content) {
            $content->delete();
            return $this->success([],"deleted");
        }else {
            return $this->fail(["message" => "content doesn't exist"], "Not found",404);
        }
    }
}
