<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'amount', 'month', 'year'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSpentAttribute()
    {
        $category = trim(strtolower($this->category));

        return $this->user->transactions()
            ->where('type', 'pengeluaran')
            ->whereMonth('date', $this->month)
            ->whereYear('date', $this->year)
            ->whereRaw('TRIM(LOWER(category)) = ?', [$category])
            ->sum('amount');
    }

    public function getPercentageAttribute()
    {
        if ($this->amount == 0) return 0;
        return ($this->spent / $this->amount) * 100;
    }

    public function getRemainingAttribute()
    {
        return $this->amount - $this->spent;
    }
}
