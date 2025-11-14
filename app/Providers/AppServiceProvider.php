<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Auto-create streak record for new users
        // Ini diperlukan agar setiap user baru otomatis punya record streak
        \App\Models\User::created(function ($user) {
            $user->streak()->create([
                'count' => 0,
                'last_income_date' => null,
            ]);
        });
    }
}