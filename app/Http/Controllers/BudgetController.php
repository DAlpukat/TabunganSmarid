<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $budgets = Auth::user()->budgets()
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get();

        $totalBudget = $budgets->sum('amount');
        $totalSpent = Auth::user()->transactions()
            ->where('type', 'pengeluaran')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        return view('budgets.index', compact('budgets', 'totalBudget', 'totalSpent'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        Auth::user()->budgets()->updateOrCreate(
            [
                'category' => $validated['category'],
                'month' => now()->month,
                'year' => now()->year,
            ],
            ['amount' => $validated['amount']]
        );

        return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil disimpan!');
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) abort(403);
        $budget->delete();

        return redirect()->route('budgets.index')->with('success', 'Anggaran dihapus!');
    }
}