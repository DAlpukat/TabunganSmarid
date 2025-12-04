<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    protected $streakController;

    public function __construct(StreakController $streakController)
    {
        $this->streakController = $streakController;
    }

    public function index()
    {
        $this->streakController->checkAndResetStreak();

        // === DATA UNTUK CHART (6 BULAN TERAKHIR) ===
        $months = [];
        $pemasukanData = [];
        $pengeluaranData = [];
        $saldoData = [];
        $currentSaldo = 0;

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->startOfMonth()->subMonths($i);
            $months[] = $date->translatedFormat('M Y');

            $masuk = auth()->user()->transactions()
                ->where('type', 'pemasukan')
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $keluar = auth()->user()->transactions()
                ->where('type', 'pengeluaran')
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $currentSaldo = $currentSaldo + $masuk - $keluar;

            $pemasukanData[] = $masuk;
            $pengeluaranData[] = $keluar;
            $saldoData[] = $currentSaldo;
        }

        // === DATA PIE CHART (TOTAL KESELURUHAN) ===
        $totalPemasukan   = auth()->user()->transactions()->where('type', 'pemasukan')->sum('amount');
        $totalPengeluaran = auth()->user()->transactions()->where('type', 'pengeluaran')->sum('amount');
        $totalUtang       = auth()->user()->debts()->where('is_paid', false)->sum('amount');

        // === QUERY TRANSAKSI UNTUK TABEL (sama seperti sebelumnya) ===
        $query = auth()->user()->transactions()->latest();

        if ($search = request('search')) {
            $query->where('description', 'like', '%' . $search . '%');
        }
        if ($type = request('type')) {
            $query->where('type', $type);
        }

        $sortBy = request('sort_by', 'date');
        $order  = request('order', 'desc');
        if (!in_array($sortBy, ['date', 'amount', 'created_at'])) $sortBy = 'date';
        if (!in_array($order, ['asc', 'desc'])) $order = 'desc';

        $query->orderBy($sortBy, $order);

        $transactions = $query->paginate(15)->appends(request()->query());

        $saldo = $totalPemasukan - $totalPengeluaran - $totalUtang;

        return view('dashboard', compact(
            'transactions',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'totalUtang',
            'months',
            'pemasukanData',
            'pengeluaranData',
            'saldoData',
            'totalPemasukan',
            'totalPengeluaran',
            'totalUtang'
        ));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'        => 'required|in:pemasukan,pengeluaran,hutang',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'description' => 'nullable|string|max:255'
        ]);

        // Jika hutang → simpan ke debts + transactions
        if ($validated['type'] === 'hutang') {
            Auth::user()->debts()->create([
                'creditor'    => $validated['description'] ?? 'Hutang',
                'amount'      => $validated['amount'],
                'description' => $validated['description'],
                'due_date'    => $validated['date'],
                'is_paid'     => false,
            ]);
        }

        // Simpan transaksi (termasuk hutang juga masuk riwayat)
        $transaction = Auth::user()->transactions()->create($validated);

        // Update streak hanya jika pemasukan
        if ($validated['type'] === 'pemasukan') {
            $this->streakController->updateStreakOnIncome();
        }

        return redirect()->route('dashboard')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->find($id);

        // Jika transaksi tidak ditemukan di transactions, cek di debts
        if (!$transaction) {
            $debt = Debt::where('user_id', Auth::id())->find($id);
            if (!$debt) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
            }
            $debt->delete();
        } else {
            $transaction->delete();
        }

        // Hitung ulang saldo setelah hapus
        $totalPemasukan   = Auth::user()->transactions()->where('type', 'pemasukan')->sum('amount');
        $totalPengeluaran = Auth::user()->transactions()->where('type', 'pengeluaran')->sum('amount');
        $totalUtang       = Auth::user()->debts()->where('is_paid', false)->sum('amount');
        $saldo            = $totalPemasukan - $totalPengeluaran - $totalUtang;

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus',
                'newSummary' => [
                    'totalPemasukan'   => 'Rp ' . number_format($totalPemasukan, 0, ',', '.'),
                    'totalPengeluaran' => 'Rp ' . number_format($totalPengeluaran, 0, ',', '.'),
                    'totalUtang'       => 'Rp ' . number_format($totalUtang, 0, ',', '.'),
                    'saldo'            => 'Rp ' . number_format($saldo, 0, ',', '.'),
                ]
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil dihapus!');
    }
}