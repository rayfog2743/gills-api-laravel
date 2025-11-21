<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;
class ProductImage extends Model
{
        public $guarded = [];
        
        protected $appends = ['image_url'];

         public function product()
        {
                return $this->belongsTo(product::class);
        }


        public function getImageUrlAttribute()
        {
            // return $this->image ? Storage::disk('public')->url($this->image) : null;
              return $this->image ? asset('storage/' . $this->image) : null;
        }
}
