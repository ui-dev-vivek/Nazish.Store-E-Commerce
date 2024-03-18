<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'body',
        'is_active',
        'user_id',
        'group_id',
        'views_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->belongsTo(Group::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_map', 'blog_id', 'category_id');
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
