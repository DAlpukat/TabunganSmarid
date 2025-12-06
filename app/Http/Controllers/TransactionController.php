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

        $query = Auth::user()->transactions();

        if ($search = $request->input('search')) {
            $query->where('description', 'like', "%{$search}%");
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        $sortBy = $request->input('sort_by', 'date');
        $order = $request->input('order', 'desc');
        $allowedSort = ['date', 'amount', 'created_at'];
        $sortBy = in_array($sortBy, $allowedSort) ? $sortBy : 'date';
        $order = in_array($order, ['asc', 'desc']) ? $order : 'desc';
        $query->orderBy($sortBy, $order);

        $transactions = $query->paginate(15)->appends($request->query());

        $totalPemasukan = Auth::user()->transactions()->where('type', 'pemasukan')->sum('amount');
        $totalPengeluaran = Auth::user()->transactions()->where('type', 'pengeluaran')->sum('amount');
        $totalUtang = Auth::user()->debts()->where('is_paid', false)->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran;

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

            $currentSaldo += $masuk - $keluar;
            $pemasukanData[] = $masuk;
            $pengeluaranData[] = $keluar;
            $saldoData[] = $currentSaldo;
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'table' => view('partials.transaction-table', compact('transactions'))->render(),
                'pagination' => $transactions->links()->render(),
                'summary' => [
                    'totalPemasukan' => 'Rp ' . number_format($totalPemasukan, 0, ',', '.'),
                    'totalPengeluaran' => 'Rp ' . number_format($totalPengeluaran, 0, ',', '.'),
                    'totalUtang' => $totalUtang > 0 ? '- Rp ' . number_format($totalUtang, 0, ',', '.') : 'Rp 0',
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
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        $category = ($validated['type'] === 'pengeluaran' && !empty($validated['category']))
            ? trim($validated['category'])
            : null;

        // Buat transaksi dulu
        $transaction = Auth::user()->transactions()->create([
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'description' => $validated['description'] ?? null,
            'category' => $category,
        ]);

        // Kalau hutang → buat debt dan link via debt_id
        if ($validated['type'] === 'hutang') {
            $debt = Auth::user()->debts()->create([
                'creditor' => $validated['description'] ?? 'Hutang',
                'amount' => $validated['amount'],
                'description' => $validated['description'],
                'due_date' => $validated['date'],
                'is_paid' => false,
            ]);

            // Link transaksi dengan debt (INI YANG BIKIN SYNC SEMPURNA)
            $transaction->update(['debt_id' => $debt->id]);
        }

        if ($validated['type'] === 'pemasukan') {
            $this->streakController->updateStreakOnIncome();
        }

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);

        // HAPUS DEBT JIKA INI TRANSAKSI HUTANG
        if ($transaction->type === 'hutang') {
            if ($transaction->debt_id) {
                // Cara paling akurat & cepat (pakai foreign key)
                optional(Debt::find($transaction->debt_id))->delete(); // cascade otomatis hapus transaksi juga, tapi kita udah delete manual
            } else {
                // Fallback untuk transaksi hutang lama (sebelum ada debt_id)
                if ($transaction->description && str_starts_with($transaction->description, '[Hutang:')) {
                    $endPos = strpos($transaction->description, ']');
                    if ($endPos !== false) {
                        $creditor = trim(substr($transaction->description, 8, $endPos - 8));
                        Auth::user()->debts()
                            ->where('creditor', 'like', "%{$creditor}%")
                            ->where('amount', $transaction->amount)
                            ->where('is_paid', false)
                            ->first()?->delete();
                    }
                }
            }
        }

        $transaction->delete();

        // Hitung ulang summary
        $totalPemasukan = Auth::user()->transactions()->where('type', 'pemasukan')->sum('amount');
        $totalPengeluaran = Auth::user()->transactions()->where('type', 'pengeluaran')->sum('amount');
        $totalUtang = Auth::user()->debts()->where('is_paid', false)->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return response()->json([
            'success' => true,
            'message' => 'Riwayat Transaksi Berhasil Dihapus',
            'deletedTransactionId' => $transaction->id,
            'newSummary' => [
                'totalPemasukan' => 'Rp ' . number_format($totalPemasukan, 0, ',', '.'),
                'totalPengeluaran' => 'Rp ' . number_format($totalPengeluaran, 0, ',', '.'),
                'totalUtang' => $totalUtang > 0 ? '- Rp ' . number_format($totalUtang, 0, ',', '.') : 'Rp 0',
                'saldo' => 'Rp ' . number_format($saldo + $totalUtang, 0, ',', '.'),
            ]
        ]);
    }
}