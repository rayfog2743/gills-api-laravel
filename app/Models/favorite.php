<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class favorite extends Model
{
    public $guarded=[];
    
     public function user()    { return $this->belongsTo(User::class); }
    public function product() { return $this->belongsTo(product::class); }
}
