<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    //Product
    //productImage
    //image
}