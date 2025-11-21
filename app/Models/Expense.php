<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'date',
        'category_id',
        'amount',
        'mode',
        'vendor_name',
        'description',
        'proof',
    ];

    protected $casts = [

        'amount' => 'decimal:2',
        'date' => 'date:Y-m-d',
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    protected $appends = ['proof_url'];

    public function getProofUrlAttribute()
    {
        return $this->proof ? asset('storage/' . $this->proof) : null;
    }
}
