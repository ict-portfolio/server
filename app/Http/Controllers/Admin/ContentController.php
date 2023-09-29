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
    public function store(ContentRequest $req)
    {
        $content = Request(["name","category_id","image_id","description","status","paragraph"]);
        $content['slug'] = Str::slug(Request()->name);
        $data = new Content($content);
        $data->save();
        return $this->success($data,"Successfully created the {$data->name}",201);
    }
    public function show($slug)
    {
        $data = Content::where('slug',$slug)->with(['category','image'])->first();
        if($data) {
            return $this->success(new ContentResource($data),"detail of {$data->name}");
        }else {
            return $this->fail(["message" => "content doesn't exist",],"Not Found",404);
        }
    }
    public function update(ContentRequest $req, $slug)
    {
        $data = Content::where('slug',$slug)->first();
        if($data) {
            $content = Request(["name","category_id","tags","image_id","description","status","paragraph"]);
            $content['slug'] = Str::slug(Request()->name);
            $data->update($content);
            return $this->success($data, "Successfully updated the {$data->name}");
        }else {
            return $this->fail(["message" => "content doesn't exist",],"Not Found",404);
        }
    }
}
