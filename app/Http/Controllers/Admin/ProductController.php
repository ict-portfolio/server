<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Controllers\ResponseController;

class ProductController extends ResponseController
{
    protected function productImageStore($images,$product_id)
    {
        foreach($images as $image) {
            $productImage = new ProductImage();
            $productImage->product_id = $product_id;
            $productImage->image_id = $image;
            $productImage->save();
        }
    }
    protected function productImageDelete($product)
    {
        $existProductImage = ProductImage::where('product_id',$product);
        if($existProductImage) {
            $existProductImage->delete();
        }
    }
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->name);
        unset($data['images']);
        $product = Product::create($data);
        $this->productImageStore($request->images,$product->id);
        return $this->success($product,"Created Product",201);
    }

    public function index()
    {
        $products = Product::all();
        $data = ProductResource::collection($products);
        return $this->success($data, "all products", 200);
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->with('images.image')->first();
        if ($product) {
            return $this->success(new ProductResource($product), "show detail");
        } else {
            return $this->fail(["message" => "product not found"], "not found", 404);
        }
    }
    public function update(ProductRequest $request, $id)
    {
        $product = Product::where('id', $id)->first();
        if ($product) {
            $data = $request->validated();
            $data['slug'] = Str::slug($request->name);
            unset($data['images']);
            $product->update($data);
            $this->productImageDelete($product->id);
            $this->productImageStore($request->images,$product->id);
            return $this->success($product, "updated the product");
        } else {
            return $this->fail(["message" => "product doesn't exist"], "not found", 404);
        }
    }
    public function destroy($id)
    {
        $product = Product::where('id', $id)->first();
        if ($product) {
            $this->productImageDelete($product->id);
            $product->delete();
            return $this->success([], "product deleted");
        } else {
            return $this->fail(["message" => "product doesn't exist"], "not found", 404);
        }
    }
}
