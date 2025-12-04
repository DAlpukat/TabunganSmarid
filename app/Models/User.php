<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'is_admin' // ← JANGAN LUPA TAMBAHKAN INI! AdminSeeder gagal kalau tidak ada
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean', // ← Tambahkan ini
    ];

    // Relasi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }

    public function streak()
    {
        return $this->hasOne(Streak::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    // Avatar accessor (biar gampang di blade)
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? Storage::url($this->avatar) : asset('images/default-avatar.jpg');
    }
}