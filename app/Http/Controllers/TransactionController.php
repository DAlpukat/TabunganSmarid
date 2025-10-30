<?php

namespace App\Http\Controllers;
use App\Models\Debt;
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
        
        // AMBIL DARI TABEL DEBTS YANG BELUM LUNAS
        $totalUtang = auth()->user()->debts()->where('is_paid', false)->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran - $totalUtang;

        return view('dashboard', compact(
            'transactions',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'totalUtang'
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
        // PERBAIKAN: Ganti "utang" menjadi "hutang"
        $validated = $request->validate([
            'type' => 'required|in:pemasukan,pengeluaran,hutang', // <-- "hutang"
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255'
        ]);

        if ($validated['type'] === 'hutang') {
            // Simpan ke debts
            auth()->user()->debts()->create([
                'creditor' => $validated['description'] ?? 'Tidak disebutkan',
                'amount' => $validated['amount'],
                'description' => $validated['description'],
                'due_date' => $validated['date']
            ]);
            // Simpan juga ke transactions agar tampil di riwayat
            auth()->user()->transactions()->create($validated);
        } else {
            auth()->user()->transactions()->create($validated);
        }

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
    // Coba cari di transactions dulu
    $transaction = Transaction::find($id);
    $debt = null;

    if (!$transaction) {
        // Jika tidak ada di transactions, coba di debts
        $debt = Debt::find($id);
        if (!$debt || $debt->user_id !== auth()->id()) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan atau tidak diizinkan'], 403);
            }
            abort(403);
        }
        $debt->delete();
    } else {
        // Validasi kepemilikan transaksi
        if ($transaction->user_id !== auth()->id()) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan atau tidak diizinkan'], 403);
            }
            abort(403);
        }
        $transaction->delete();
    }

    // Hitung ulang semua ringkasan keuangan (termasuk utang)
    $totalPemasukan = auth()->user()->transactions()
                        ->where('type', 'pemasukan')
                        ->sum('amount');

    $totalPengeluaran = auth()->user()->transactions()
                        ->where('type', 'pengeluaran')
                        ->sum('amount');

    $totalUtang = auth()->user()->debts()
                    ->where('is_paid', false)
                    ->sum('amount');

    $saldo = $totalPemasukan - $totalPengeluaran - $totalUtang;

    if (request()->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'newSummary' => [
                'totalPemasukan' => $totalPemasukan,
                'totalPengeluaran' => $totalPengeluaran,
                'totalUtang' => $totalUtang, // <-- TAMBAHKAN
                'saldo' => $saldo
            ]
        ]);
    }

    return redirect()->route('dashboard')
        ->with('success', 'Data berhasil dihapus!');

}
}