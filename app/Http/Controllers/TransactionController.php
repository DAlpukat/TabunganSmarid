<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index()
    {
        $transactions = auth()->user()->transactions()->latest()->paginate(10); 

        $totalPemasukan = auth()->user()->transactions()
                            ->where('type', 'pemasukan')
                            ->sum('amount');

        $totalPengeluaran = auth()->user()->transactions()
                            ->where('type', 'pengeluaran')
                            ->sum('amount');

        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('dashboard', compact(
            'transactions',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'type' => 'required|in:pemasukan,pengeluaran',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255'
        ]);

        auth()->user()->transactions()->create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Transaksi berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

        /**
         * Remove the specified resource from storage.
         */
        /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        // Pastikan hanya pemilik transaksi yang bisa menghapus
        if ($transaction->user_id !== auth()->id()) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            abort(403);
        }
        
        $transaction->delete();
        
        // Hitung ulang ringkasan keuangan
        $totalPemasukan = auth()->user()->transactions()
                            ->where('type', 'pemasukan')
                            ->sum('amount');

        $totalPengeluaran = auth()->user()->transactions()
                            ->where('type', 'pengeluaran')
                            ->sum('amount');

        $saldo = $totalPemasukan - $totalPengeluaran;
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus',
                'newSummary' => [
                    'totalPemasukan' => $totalPemasukan,
                    'totalPengeluaran' => $totalPengeluaran,
                    'saldo' => $saldo
                ]
            ]);
        }
        
        return redirect()->route('dashboard')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}
