<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;
    public function image(){
        return $this->belongsTo(Image::class);
    }
    public function file(){
        return $this->belongsTo(File::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
