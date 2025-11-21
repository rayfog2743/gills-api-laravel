<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $guarded = [''];

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    // Accessor to return full URL if using public disk
    protected $appends = ['image_url'];
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }

    public function products()
{
    return $this->belongsToMany(\App\Models\Product::class, 'product_attribute') // <-- not attribute_product
        ->withPivot(['price','stock','image'])
        ->withTimestamps();
}

public function images()
{
    return $this->hasMany(AttributeValueImage::class)->orderBy('sort_order');
}



}
