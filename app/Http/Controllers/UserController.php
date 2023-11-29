<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends ResponseController
{
    public function index()
    {
        return $this->success(User::with('roles')->latest()->get() , "Fetched all users" , 200);
    }

    public function show(Request $req)
    {
        $user = $req->user();
        return $this->success(User::where('id' , $user->id)->with('roles')->first() , "User found" , 200);
    }

    public function makeAdmin($id)
    {
        $user = User::where('id' , $id)->first();
        if ($user) {
            $user->assignRole('admin');
            return $this->success($user , "Successfully promoted to Admin" , 200);
        } else {
            return $this->fail('' , 'User Not Found' , 404);
        }
    }

    public function demoteAdmin($id)
    {
        $user = User::where('id' , $id)->first();
        if ($user) {
            $user->removeRole('admin');
            return $this->success($user , "Successfully demoted to User" , 200);
        } else {
            return $this->fail('' , 'User Not Found' , 404);
        }
    }

    public function register(UserRequest $req)
    {
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        if ($req->image_id) {
            $user->image_id = $req->image_id;
        }
        $user->save();
        $user->assignRole('client');

        $token = $user->createToken("first-ict")->plainTextToken;
        return $this->success([
            "user" => $user,
            "token" => $token
        ] , "Registered Successfully" , 201);
    }
    public function login(UserRequest $req)
    {
        $user = User::where('email' , $req->email)->first();
        if ($user) {
            if (Hash::check($req->password , $user->password)) {
                $user->created = Carbon::parse($user->created_at)->format('j-F-Y');
                $token = $user->createToken("first-ict")->plainTextToken;
                return $this->success([
                    "user" => $user,
                    "token" => $token
                ] , "Logged in successfully" , 200);
            } else {
                return $this->fail(["password" => ["Wrong Password"]] , "Credential Error" , 422);
            }
        } else {
            return $this->fail(["email" => ["There is no user with this email"]] , "Credential Error" , 404);
        }
    }
}
