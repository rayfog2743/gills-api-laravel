<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    public $guarded = [];

    public function category()
        {
            return $this->belongsTo(category::class, 'category', 'id');
        }

     protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }  
    
    public function vendor()
        {
            return $this->belongsTo(Vendor::class);
        }

        public function inventories()
        {
            return $this->hasMany(Inventory::class);
        }

            public function images()
        {
            return $this->hasMany(ProductImage::class);
        }

        public function variations()
            {
                return $this->belongsToMany(Variation::class, 'product_variation')->withTimestamps();
            }

            public function attributes()
            {
                return $this->belongsToMany(Attribute::class, 'product_attribute')
                    ->withPivot(['price', 'stock', 'image'])
                    ->withTimestamps();
            }

         // inside Product model

            public function featuredImage()
            {
                return $this->hasOne(ProductImage::class)->where('is_featured', true);
            }   







}
