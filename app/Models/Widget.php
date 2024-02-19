<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;
    protected $fillable = [
        'wi_name',
        'wi_image',
        'wi_type',
        'ref_url',
        'wi_h1',
        'wi_p',
        'wi_p2',
        'style_type',
    ];
}
