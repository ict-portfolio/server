<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ResponseController;

class FileController extends ResponseController
{
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(),[
            "url" => "required"
        ]);
        if($validator->fails()) {
            return $this->fail($validator->errors(),"Validation failed",422);
        }
        $localhostName = env("APP_URL","localhost:8000");
        $url = $req->file('url');
        $fileName = time()."_".$url->getClientOriginalName();
        $url->storeAs('files',$fileName);
        $data=new File();
        $data->url = $localhostName."/storage/".$fileName;
        $data->save();
        return $this->success($data,"Image uploaded successfully.",201);
    }
}
