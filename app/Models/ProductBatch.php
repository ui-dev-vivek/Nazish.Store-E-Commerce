<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBatch extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_batch',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
