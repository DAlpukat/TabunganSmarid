<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function index()
    {
        $debts = auth()->user()->debts()->latest()->get();
        return view('debts.index', compact('debts'));
    }

    public function create()
    {
        return view('debts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'creditor' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
            'due_date' => 'nullable|date'
        ]);
        $validated['is_paid'] = false;

        // Simpan ke debts
        $debt = auth()->user()->debts()->create($validated);

        // Simpan ke transactions dengan ID debt di description (untuk sync hapus)
        auth()->user()->transactions()->create([
            'type' => 'hutang',
            'amount' => $validated['amount'],
            'description' => '[Hutang ID:' . $debt->id . '] ' . ($validated['description'] ?? 'Hutang ke ' . $validated['creditor']),
            'date' => $validated['due_date'] ?? now(),
        ]);

        return redirect()->route('debts.index')->with('success', 'Hutang berhasil ditambahkan!');
    }

    public function update(Request $request, Debt $debt)
    {
        // Melunasi hutang
        if ($debt->user_id !== auth()->id()) abort(403);
        $debt->update(['is_paid' => true]);
        return redirect()->route('debts.index')->with('success', 'Hutang berhasil dilunasi!');
    }

    public function destroy(Debt $debt)
    {
        $this->authorize('delete', $debt); // atau manual check
        if ($debt->user_id !== auth()->id()) abort(403);

        // Hapus transaksi hutang terkait (jika ada)
        $transaction = auth()->user()->transactions()
            ->where('type', 'hutang')
            ->where('amount', $debt->amount)
            ->whereDate('date', $debt->due_date ?? now())
            ->first();

        if ($transaction) $transaction->delete();

        $debt->delete();

        return redirect()->route('debts.index')->with('success', 'Hutang berhasil dihapus permanen!');
    }
}