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
        $product = Product::latest()->paginate(12);
        $data=ProductResource::collection($product);
        return $this->success($data,'latest products');
    }

    public function productDetails($slug)
    {
        $product = Product::where('slug', $slug)->with('images.image' , 'category')->first();
        if ($product) {
            return $this->success(new ProductResource($product), "show detail");
        } else {
            return $this->fail(["message" => "product not found"], "not found", 404);
        }
    }
    public function relatedProducts( $product_id , $category_id)
    {
        $products = Product::where('category_id', $category_id)->where('id', '<>', $product_id)->latest()->paginate(4);
        if ($products) {
            return $this->success(ProductResource::collection($products), "show detail");
        } else {
            return $this->fail(["message" => "product not found"], "not found", 404);
        }
    }

}
