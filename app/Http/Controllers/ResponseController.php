<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function success($data,$message,$code = 200)
    {
        return $this->ApiResponse($data,[],$message,true,$code);
    }
    public function fail($errors,$message,$code)
    {
        return $this->ApiResponse([],$errors,$message,false,$code);
    }
    public function ApiResponse($data,$error,$message,$condition,$code)
    {
        return response()->json([
            "data" => $data,
            "errors" => $error,
            "message" => $message,
            "condition" => $condition
        ],$code);
    }
}
