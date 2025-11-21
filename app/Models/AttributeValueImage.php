<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValueImage extends Model
{
    //

    public $table="attribute_value_images";
    public $guarded = [];

    protected $appends = ['url'];

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }

    public function getUrlAttribute()
    {
        return $this->path ? Storage::disk('public')->url($this->path) : null;
    }
}
