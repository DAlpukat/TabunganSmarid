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

    public function index(Request $request)
    {
        $this->streakController->checkAndResetStreak();

        // Query transaksi
        $query = Auth::user()->transactions();

        // Search
        if ($search = $request->input('search')) {
            $query->where('description', 'like', "%{$search}%");
        }

        // Filter type
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'date');
        $order = $request->input('order', 'desc');
        $allowedSort = ['date', 'amount', 'created_at'];
        $sortBy = in_array($sortBy, $allowedSort) ? $sortBy : 'date';
        $order = in_array($order, ['asc', 'desc']) ? $order : 'desc';
        $query->orderBy($sortBy, $order);

        $transactions = $query->paginate(15)->appends($request->query());

        // Hitung ringkasan
        $totalPemasukan = Auth::user()->transactions()->where('type', 'pemasukan')->sum('amount');
        $totalPengeluaran = Auth::user()->transactions()->where('type', 'pengeluaran')->sum('amount');
        $totalUtang = Auth::user()->debts()->where('is_paid', false)->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran - $totalUtang;

        // Data chart 6 bulan
        $months = [];
        $pemasukanData = [];
        $pengeluaranData = [];
        $saldoData = [];
        $currentSaldo = 0;

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->startOfMonth()->subMonths($i);
            $months[] = $date->translatedFormat('M Y');

            $masuk = Auth::user()->transactions()
                ->where('type', 'pemasukan')
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $keluar = Auth::user()->transactions()
                ->where('type', 'pengeluaran')
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $currentSaldo = $currentSaldo + $masuk - $keluar;
            $pemasukanData[] = $masuk;
            $pengeluaranData[] = $keluar;
            $saldoData[] = $currentSaldo;
        }

        // HANYA untuk AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'table' => view('partials.transaction-table', compact('transactions'))->render(),
                'pagination' => $transactions->links()->render(),
                'summary' => [
                    'totalPemasukan' => 'Rp ' . number_format($totalPemasukan, 0, ',', '.'),
                    'totalPengeluaran' => 'Rp ' . number_format($totalPengeluaran, 0, ',', '.'),
                    'totalUtang' => 'Rp ' . number_format($totalUtang, 0, ',', '.'),
                    'saldo' => 'Rp ' . number_format($saldo + $totalUtang, 0, ',', '.'),
                ],
                'chart' => [
                    'months' => $months,
                    'pemasukan' => $pemasukanData,
                    'pengeluaran' => $pengeluaranData,
                    'saldo' => $saldoData,
                    'pie' => [$totalPemasukan, $totalPengeluaran, $totalUtang]
                ]
            ]);
        }

        // Untuk NON-AJAX request (normal page load)
        return view('dashboard', compact(
            'transactions',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'totalUtang',
            'months',
            'pemasukanData',
            'pengeluaranData',
            'saldoData'
        ));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:pemasukan,pengeluaran,hutang',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255'
        ]);

        // Jika hutang → simpan ke debts + transactions
        if ($validated['type'] === 'hutang') {
            Auth::user()->debts()->create([
                'creditor' => $validated['description'] ?? 'Hutang',
                'amount' => $validated['amount'],
                'description' => $validated['description'],
                'due_date' => $validated['date'],
                'is_paid' => false,
            ]);
        }

        // Simpan transaksi
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

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        // Jika ini transaksi hutang → hapus debt terkait juga
        if ($transaction->type === 'hutang') {
            if (str_starts_with($transaction->description, '[Hutang ID:')) {
                $endPos = strpos($transaction->description, ']');
                if ($endPos !== false) {
                    $debtId = substr($transaction->description, 11, $endPos - 11);
                    $debt = Debt::where('id', $debtId)->where('user_id', Auth::id())->first();
                    if ($debt) {
                        $debt->delete();
                    }
                }
            }
        }

        $transaction->delete();

        // Hitung ulang (sama seperti sebelumnya)
        $totalPemasukan = Auth::user()->transactions()->where('type', 'pemasukan')->sum('amount');
        $totalPengeluaran = Auth::user()->transactions()->where('type', 'pengeluaran')->sum('amount');
        $totalUtang = Auth::user()->debts()->where('is_paid', false)->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran - $totalUtang;

        return response()->json([
            'success' => true,
            'message' => 'Hutang berhasil dihapus permanen dari riwayat dan daftar hutang!',
            'newSummary' => [
                'totalPemasukan' => 'Rp ' . number_format($totalPemasukan, 0, ',', '.'),
                'totalPengeluaran' => 'Rp ' . number_format($totalPengeluaran, 0, ',', '.'),
                'totalUtang' => $totalUtang > 0 ? '- Rp ' . number_format($totalUtang, 0, ',', '.') : 'Rp 0',
                'saldo' => 'Rp ' . number_format($saldo + $totalUtang, 0, ',', '.'),
            ]
        ]);
    }
}