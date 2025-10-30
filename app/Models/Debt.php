<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'creditor',
        'amount',
        'description',
        'due_date',
        'is_paid'
    ];

    protected $casts = ['due_date' => 'date', 'is_paid' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getFormattedDueDateAttribute()
    {
        return $this->due_date ? $this->due_date->format('d/m/Y') : '-';
    }
}