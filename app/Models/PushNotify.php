<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotify extends Model
{
    use HasFactory;
    protected $fillable = [
        'body',
        'pushing_date',
        'ref_link',
        'image_url',
    ];

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_url');
    }
}
