<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class StreakIcon extends Component
{
    /**
     * The CSS class for the container.
     */
    public string $class;

    /**
     * The size of the icon (e.g., '8', '6').
     */
    public string $size;

    /**
     * The ID for the streak count element.
     */
    public string $id;

    /**
     * The CSS class for the text.
     */
    public string $textClass;

    /**
     * Create a new component instance.
     */
    public function __construct(string $class = 'mr-4', string $size = '8', string $id = '', string $textClass = '')
    {
        $this->class = $class;
        $this->size = $size;
        $this->id = $id;
        $this->textClass = $textClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        // Logika dijalankan SETIAP KALI komponen dipanggil
        // Ini menjamin data selalu fresh untuk user yang sedang login
        $user = Auth::user();

        $streakCount = $user->streak->count ?? 0;
        $hasIncomeToday = false;

        if ($user) {
            $hasIncomeToday = $user->transactions()
                                        ->where('type', 'pemasukan')
                                        ->whereDate('date', now()->toDateString())
                                        ->exists();
        }

        return view('components.streak-icon', [
            'hasIncomeToday' => $hasIncomeToday,
            'streakCount' => $streakCount
        ]);
    }
}