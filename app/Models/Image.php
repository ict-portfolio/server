<?php

namespace App\Models;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;
    public function slider()
    {
        return $this->hasOne(Slider::class);
    }
}
