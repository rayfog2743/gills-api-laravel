<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public $guarded=[];

// redirect_url
     protected $appends = ['redirect_url'];

    public function getRedirectUrlAttribute()
    {
        return $this->image_url ? asset('storage/' . $this->image_url) : null;
    }



}
