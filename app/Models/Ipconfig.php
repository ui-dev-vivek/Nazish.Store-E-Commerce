<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipconfig extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_ip',
        'cookies_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
