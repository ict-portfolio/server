<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ResponseController
{
    public function getLatestProducts(){
        $product = Product::latest()->paginate(3);
        $data=ProductResource::collection($product);
        return $this->success($data,'latest products');
    }

    public function productDetails($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if ($product) {
            return $this->success(new ProductResource($product), "show detail");
        } else {
            return $this->fail(["message" => "product not found"], "not found", 404);
        }
    }
    public function relatedProducts($category_id)
    {
        $product = Product::where('category_id', $category_id)->first();
        if ($product) {
            return $this->success(new Product($product), "show detail");
        } else {
            return $this->fail(["message" => "product not found"], "not found", 404);
        }
    }

}
