<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'groups';

    protected $fillable = [
        'group_name',
        'group_code',
    ];

    public function product()
    {
        return $this->belongsToMany(Product::class, 'group_product', 'group_id', 'product_id');
    }
}
