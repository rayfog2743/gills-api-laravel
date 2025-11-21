<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //
    public $guarded = [];

    public function product()
{
    return $this->belongsTo(product::class);
}

public function vendor()
{
    return $this->belongsTo(Vendor::class);
}
}
