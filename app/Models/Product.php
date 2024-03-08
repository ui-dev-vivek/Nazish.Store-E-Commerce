<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'sub_title',
        'slug',
        'body',
        'points',
        'is_active',
        'user_id',
        'group_id',
        'thumbnail',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function priceTag()
    {
        return $this->hasMany(PriceTag::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_map', 'product_id', 'category_id');
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_product', 'product_id', 'group_id');
    }
    public function images()
    {
        return $this->belongsToMany(Image::class, 'product_images', 'product_id', 'image_id');
    }
    public static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (Auth::check()) {
                $product->user_id = Auth::id();
                $product->group_id = 1;
            } else {
                $product->user_id = null;
                $product->group_id = 1;
            }
        });
        static::creating(function ($model) {
            $model->slug = Str::slug($model->title);
        });

        static::updating(function ($model) {
            if ($model->isDirty('title')) {
                $model->slug = Str::slug($model->slug);
            }
        });
    }
}
