<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function contents()
    {
        return $this->hasMany(Content::class);
    }
    public function root_category()
    {
        return $this->belongsTo(RootCategory::class,'root_category_id');
    }
}
