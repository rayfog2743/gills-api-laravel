<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salesmodel extends Model
{
    public $table="sales_banners";
    public $guarded=[];
    
    
      protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return $this->image_url ? asset('storage/' . $this->image_url) : null;
    }  
    
}
