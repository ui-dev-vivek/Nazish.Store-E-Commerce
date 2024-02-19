<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'ref_link',
        'price',
        'discount_type',
        'discount',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
