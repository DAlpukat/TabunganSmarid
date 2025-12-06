<style>
        .gradient-bg {
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5530 100%);
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        .glass-card {
            background: rgba(22, 101, 52, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 16px;
            position: relative;
            z-index: 2;
        }

        .stat-card {
            background: rgba(22, 101, 52, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(22, 101, 52, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, #059669, #34d399);
            border: none;
            border-radius: 8px;
            color: #065f46;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
            background: linear-gradient(135deg, #047857, #10b981);
        }

        .table-header {
            background: rgba(22, 101, 52, 0.3) !important;
            border-bottom: 1px solid rgba(34, 197, 94, 0.3);
        }

        .table-row {
            border-bottom: 1px solid rgba(34, 197, 94, 0.1);
            transition: background 0.2s ease;
        }

        .table-row:hover {
            background: rgba(22, 101, 52, 0.2);
        }

        .glass-modal {
            background: rgba(22, 101, 52, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 16px;
        }

        .pattern-overlay {
            background-image: radial-gradient(circle at 25% 25%, rgba(34, 197, 94, 0.1) 2px, transparent 2px),
                              radial-gradient(circle at 75% 75%, rgba(34, 197, 94, 0.05) 1px, transparent 1px);
            background-size: 40px 40px, 20px 20px;
            opacity: 0.3;
        }

        /* OPTIMASI SCROLL MAKSIMAL */
        .transaction-table-wrapper {
            max-height: 70vh;
            overflow-y: auto;
            contain: paint; /* INI YANG BIKIN 60FPS */
            will-change: scroll-position;
            scrollbar-width: thin;
            scrollbar-color: #22c55e #1a3a32;
            border-radius: 12px;
        }

        .transaction-table-wrapper::-webkit-scrollbar {
            width: 8px;
        }

        .transaction-table-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }

        .transaction-table-wrapper::-webkit-scrollbar-thumb {
            background: #22c55e;
            border-radius: 4px;
        }

        #transactionTable {
            opacity: 1;
            transition: opacity 0.15s ease-out;
            will-change: opacity;
        }

        #transactionTable.loading {
            opacity: 0.4;
        }

        /* Skeleton untuk chart */
        .chart-skeleton {
            background: linear-gradient(90deg, #1a3a32 25%, #162922 50%, #1a3a32 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            height: 300px;
            border-radius: 12px;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }


        .btn-delete {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fecaca;
            font-weight: 600;
            padding: 6px 14px;           /* biar ada ruang dalam */
            border-radius: 10px;         /* ini yang bikin bulat lembut */
            transition: all 0.3s ease;
            font-size: 0.875rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.45);
            border-color: rgba(239, 68, 68, 0.7);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
        }
    </style>
<table class="w-full">
    <thead class="table-header">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-green-300 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-green-300 uppercase tracking-wider">Jenis</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-green-300 uppercase tracking-wider">Jumlah</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-green-300 uppercase tracking-wider">Deskripsi</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-green-300 uppercase tracking-wider">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-700">
        @forelse($transactions as $transaction)
            <tr id="transaction-{{ $transaction->id }}" class="table-row">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                    {{ $transaction->formatted_date }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $transaction->type === 'pemasukan' ? 'bg-green-500/20 text-green-300 border border-green-500/30' : 
                           ($transaction->type === 'hutang' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 
                           'bg-red-500/20 text-red-300 border border-red-500/30') }}">
                        {{ ucfirst($transaction->type) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold 
                    {{ $transaction->type === 'pemasukan' ? 'text-green-300' : 'text-red-300' }}">
                    {{ $transaction->type === 'pemasukan' ? '+' : '-' }}{{ $transaction->formatted_amount }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-200">
                    @php
                        $desc = $transaction->description ?? '-';
                        if ($transaction->type === 'hutang' && str_starts_with($desc, '[Hutang ID:')) {
                            $endPos = strpos($desc, '] ');
                            if ($endPos !== false) {
                                $desc = substr($desc, $endPos + 2);
                            }
                        }
                    @endphp
                    {{ $desc ?: '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="deleteTransaction({{ $transaction->id }})"
                            class="btn-delete text-sm font-medium">
                        Hapus
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-12 text-gray-500 text-lg">
                    Belum ada transaksi
                </td>
            </tr>
        @endforelse
    </tbody>
</table>