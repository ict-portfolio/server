<?php

namespace App\Http\Controllers\Client;

use App\Models\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;
use App\Http\Controllers\ResponseController;

class ContentController extends ResponseController
{
    public function getLatestContents(){
        $contents = Content::latest()->paginate(12);
        $data=ContentResource::collection($contents);
        return $this->success($data,'latest contents');
    }

    public function contentDetails($slug)
    {
        $content = Content::where('slug', $slug)->with('image','category')->first();
        if ($content) {
            return $this->success(new ContentResource($content), "show detail");
        } else {
            return $this->fail(["message" => "content not found"], "not found", 404);
        }
    }

    public function relatedContents($content_id , $category_id)
    {
        $contents = Content::where('category_id', $category_id)->where('id', '!=', $content_id)->with('image')->latest()->paginate(4);
        if ($contents) {
            return $this->success(ContentResource::collection($contents), "show detail");
        } else {
            return $this->fail(["message" => "content not found"], "not found", 404);
        }
    }
}
