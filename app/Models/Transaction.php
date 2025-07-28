<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'description',
        'date'
    ];

    protected $casts = [
        'date' => 'date', // or 'datetime' if you need time
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* Scope untuk pemasukan */
    public function scopePemasukan($query)
    {
        return $query->where('type', 'pemasukan');
    }

      /*Scope untuk pengeluaran*/
    public function scopePengeluaran($query)
    {
        return $query->where('type', 'pengeluaran');
    }

    /*Format amount sebagai Rupiah (bisa akses via $transaction->formatted_amount)*/
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /*Format tanggal (akses via $transaction->formatted_date)*/
    public function getFormattedDateAttribute()
    {
        return $this->date ? $this->date->format('d/m/Y') : '-';
    }
}
