<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image_path',
        'user_id',
    ];

    // Relasi: setiap announcement dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}