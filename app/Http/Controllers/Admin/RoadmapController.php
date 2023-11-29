<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\RoadmapResource;
use App\Models\Roadmap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoadmapController extends ResponseController
{
    public function index()
    {
        return $this->success(RoadmapResource::collection(Roadmap::latest()->get()),"ict roadmap");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all() , [
            "title" => "required",
            "description" => "required",
            "status" => "required"
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors() , "Validation failed." , 422);
        }
        $map = new Roadmap();
        $map->title = $request->title;
        $map->description = $request->description;
        $map->status = $request->status;
        $map->save();
        return $this->success($map , 'Successfully saved to roadmap.' , 201);
    }

    public function update(Request $request , $id)
    {
        $map = Roadmap::find($id);
        if (!$map) {
            return $this->fail([] , "Not Found!" , 404);
        }
        $validator = Validator::make($request->all() , [
            "title" => "required",
            "description" => "required",
            "status" => "required"
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors() , "Validation failed." , 422);
        }
        $map->title = $request->title;
        $map->description = $request->description;
        $map->status = $request->status;
        $map->update();
        return $this->success($map , 'Successfully updated to roadmap.' , 200);

    }

    public function destroy($id)
    {
        $map = Roadmap::find($id);
        if ($map) {
            $map->delete();
            return $this->success([] , "Deleted successfully." , 200);
        } else {
            return $this->fail([] , "Not Found!" , 404);
        }
    }
}
