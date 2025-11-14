<?php

namespace App\Http\Controllers;

use App\Models\Streak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StreakController extends Controller
{
    /**
     * Method ini akan dipanggil oleh TransactionController saat ada pemasukan baru.
     */
    public function updateStreakOnIncome()
    {
        $user = Auth::user();
        if (!$user) return;

        $today = Carbon::today();

        // Dapatkan atau buat record streak untuk user
        $streak = $user->streak ?? new Streak(['user_id' => $user->id]);

        if (!$streak->last_income_date) {
            // Pertama kali dapat pemasukan
            $streak->count = 1;
        } else {
            $lastIncomeDate = $streak->last_income_date;

            if ($lastIncomeDate->isYesterday()) {
                // Lanjut streak (pemasukan kemarin)
                $streak->count += 1;
            } elseif ($lastIncomeDate->isToday()) {
                // Sudah dapat pemasukan hari ini, tidak perlu update count
                return; // Langsung keluar, tidak perlu save
            } else {
                // Streak putus (lewat dari 1 hari), mulai streak baru
                $streak->count = 1;
            }
        }

        $streak->last_income_date = $today;
        $streak->save();
    }

    /**
     * Method ini akan dipanggil oleh DashboardController saat dashboard dibuka.
     */
    public function checkAndResetStreak()
    {
        $user = Auth::user();
        if (!$user || !$user->streak || !$user->streak->last_income_date) {
            return;
        }

        $streak = $user->streak;
        $lastIncomeDate = $streak->last_income_date;

        // Jika hari terakhir pemasukan adalah sebelum kemarin (lewat dari 1 hari)
        if ($lastIncomeDate->lessThan(Carbon::yesterday())) {
            $streak->count = 0;
            $streak->last_income_date = null; // Opsional: hapus tanggal terakhir
            $streak->save();
        }
    }

    /**
     * Endpoint API untuk frontend mengambil data streak terbaru.
     */
    public function getCurrent()
    {
        $user = Auth::user();
        $streak = $user->streak;

        if (!$streak) {
            return response()->json([
                'count' => 0,
                'last_income_date' => null
            ]);
        }

        return response()->json([
            'count' => $streak->count,
            'last_income_date' => $streak->last_income_date
        ]);
    }
}