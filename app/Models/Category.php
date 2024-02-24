<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent',
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_map', 'category_id', 'product_id');
    }
    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'category_map', 'category_id', 'blog_id');
    }
}
