<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends ResponseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(Contact::latest()->get() , "Fetched All Contacts" , 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all() , [
            "name" => "required",
            "email" => "required|email",
            "message" => "required"
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors() , "Please fill out all input fields." , 422);
        }
        $data = Contact::create([
            "name" => $request->name,
            "email" => $request->email,
            "message" => $request->message
        ]);
        return $this->success($data , "Message sent successfully" , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Contact::where('id' , $id)->first();
        if ($data) {
            $data->delete();
            return $this->success([] , "Contact deleted Successfully" , 200);
        } else {
            return $this->fail(["Contact Not found"] , "Contact Not Found" , 404);
        }
    }
}
