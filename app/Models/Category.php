<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
