<?php

use App\Http\Controllers\DebtController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StreakController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |---------------------------------
    | Dashboard
    |---------------------------------
    */
    Route::get('/dashboard', [TransactionController::class, 'index'])->name('dashboard');


    /*
    |---------------------------------
    | Transaction Routes (Menggunakan Resource)
    |---------------------------------
    */
    // KEMBALIKAN KE ROUTE RESOURCE INI
    // `except` berarti kita tidak membuat route untuk method `show`, `edit`, dan `update`
    // karena kita tidak membutuhkannya.
    Route::resource('transactions', TransactionController::class)->except(['show', 'edit', 'update']);


    /*
    |---------------------------------
    | Debt Routes
    |---------------------------------
    */
    Route::resource('debts', DebtController::class);


    /*
    |---------------------------------
    | User Profile
    |---------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /*
    |---------------------------------
    | Feature Specific Routes
    |---------------------------------
    */
    // Saran
    Route::post('/suggestions', [SuggestionController::class, 'store'])->name('suggestions.store');

    // Streak (Endpoint API untuk frontend)
    Route::get('/streak/current', [StreakController::class, 'getCurrent'])->name('streak.current');

});