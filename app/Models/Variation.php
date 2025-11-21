<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
     protected $guarded = [''];

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }


    public function products()
{
    return $this->belongsToMany(product::class, 'product_variation')->withTimestamps();
}



}
