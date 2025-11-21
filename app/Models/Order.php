<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    //

    public $guarded = [];
      protected $casts = [
        'items' => 'array',   // auto-cast JSON to array
        'order_time' => 'datetime',
    ];
    
    protected $appends = ['order_time_formatted','items_summary'];

    public function getOrderTimeFormattedAttribute()
    {
        return $this->order_time 
            ? Carbon::parse($this->order_time)->format('M d, Y - g:i A')
            : null;
    }
    
    
    // protected $appends = ['items_summary'];

    public function getItemsSummaryAttribute()
    {
        if (!is_array($this->items)) {
            return null;
        }

        return collect($this->items)
            ->map(function ($item) {
                return $item['name'] . " . " . $item['qty'] . "*" . $item['price'];
            })
            ->implode(' | ');
    }
}
