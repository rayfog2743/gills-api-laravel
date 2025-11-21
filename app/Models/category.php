<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    public $table = "categories";

    public $guarded = [""];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function products()
    {
        return $this->hasMany(product::class, 'category', 'id'); 
    
    }

}
