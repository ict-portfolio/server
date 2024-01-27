<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;

class CategoryController extends ResponseController
{
    public function getProductOrServiceOfCategory ($slug) {
        $data = Category::where('slug' , $slug)->with('root_category' , 'products' , 'services')->first();
        return $this->success($data , "category" , 200);
    }
}
