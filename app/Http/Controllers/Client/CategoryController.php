<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function getProductOrServiceOfCategory ($slug) {
        $data = Category::where('slug' , $slug)->with('root_category' , 'products' , 'services')->first();
        return $data;
    }
}
