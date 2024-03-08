<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent',
    ];
    public function parent()
    {
        return $this->belongsTo(Category::class);
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_map', 'category_id', 'product_id');
    }
    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'category_map', 'category_id', 'blog_id');
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });

        static::updating(function ($model) {
            if ($model->isDirty('title')) {
                $model->slug = Str::slug($model->slug);
            }
        });
    }
}
