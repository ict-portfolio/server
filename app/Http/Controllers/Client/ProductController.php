<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ResponseController
{
    public function getLatestProducts(Request $request){
        $products = Product::latest()->paginate($request->input('limit'));
        $paginationData = [
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
        ];
        $data=ProductResource::collection($products);
        return $this->success(['products' => $data , 'meta' => $paginationData],'latest products');
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
