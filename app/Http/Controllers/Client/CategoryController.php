<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\RootCategory;

class CategoryController extends ResponseController
{
    public function getProductOrServiceOfCategory ($slug)
    {
        $data = Category::where('slug' , $slug)->with('root_category' , 'products' , 'services')->first();
        return $this->success($data , "category" , 200);
    }

    public function getCategoriesByType($type)
    {
        $categories = RootCategory::where('type' , $type)->with('categories')->latest()->get();
        $result = [];
        foreach($categories as $c) {
            $result = array_merge($result , $c->categories->toArray());
        }
        return $this->success($result , "category" , 200);
    }
}
