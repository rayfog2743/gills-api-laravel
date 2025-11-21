<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendors';
    public $guarded = [];

    public function products()
        {
            return $this->hasMany(Product::class);
        }

        public function inventories()
        {
            return $this->hasMany(Inventory::class);
        }
}
