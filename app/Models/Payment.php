<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $guarded=[];

    protected $casts = [
        'payment_details' => 'array',
        'items' => 'array',
    ];
}
