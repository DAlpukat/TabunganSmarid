<?php

use App\Http\Controllers\DebtController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StreakController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BudgetController;
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


    Route::resource('budgets', BudgetController::class)->only(['index', 'store', 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES – Kelola User & Berita
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {

        // === Kelola Pengguna (Hapus User) ===
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
            Route::delete('/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
        });

        // === Kelola Berita (sudah ada sebelumnya, saya rapikan saja) ===
        Route::resource('announcements', App\Http\Controllers\AnnouncementController::class)
            ->except(['show', 'publicIndex', 'publicShow']);
    });


    // --- Route untuk User Biasa (Lihat Berita) ---
    // Route ini TIDAK punya middleware, jadi semua orang bisa akses
    Route::get('/berita', [AnnouncementController::class, 'publicIndex'])->name('announcements.public.index');
    Route::get('/berita/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.public.show');

    // --- Route untuk Admin (Kelola Berita) ---
    // Route ini DILINDUNGI oleh middleware 'auth' dan 'admin'
    Route::prefix('admin/berita')->name('announcements.')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [AnnouncementController::class, 'index'])->name('index');
        Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
        Route::post('/', [AnnouncementController::class, 'store'])->name('store');
        Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');
        Route::put('/{announcement}', [AnnouncementController::class, 'update'])->name('update');
        Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
    });




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