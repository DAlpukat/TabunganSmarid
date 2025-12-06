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
            'amount' => $debt->amount,
            'description' => '[Hutang: ' . $debt->creditor . ']' . ($debt->description ? ' - ' . $debt->description : ''),
            'date' => $debt->due_date ?? now(),
            'debt_id' => $debt->id, // BARU: SYNC SEMPURNA
        ]);

        return redirect()->route('debts.index')->with('success', 'Hutang berhasil ditambahkan!');
    }

    public function update(Request $request, Debt $debt)
    {
        if ($debt->user_id !== auth()->id()) abort(403);

        // Buat transaksi pengeluaran otomatis saat lunasi
        auth()->user()->transactions()->create([
            'type' => 'pengeluaran',
            'amount' => $debt->amount,
            'description' => 'Pelunasan hutang: ' . $debt->creditor . 
                            ($debt->description ? ' - ' . $debt->description : ''),
            'date' => now(),
        ]);

        // Update status lunas
        $debt->update(['is_paid' => true]);

        return redirect()->route('debts.index')->with('success', 'Hutang berhasil dilunasi! Saldo telah dikurangi.');
    }

   public function destroy(Debt $debt)
    {
        
        if ($debt->user_id !== auth()->id()) {
            abort(403);
        }
        // Hapus debt, transaksi terkait akan terhapus otomatis via foreign key cascade
        $debt->delete();

        return redirect()
            ->route('debts.index')
            ->with('success', 'Hutang berhasil dihapus permanen! Riwayat transaksi hutang juga ikut terhapus otomatis.');
    }
}