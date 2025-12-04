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
                    {{ $transaction->description ?? '-' }}
                </td>
                <td class="px-6 py-4">
                    <button onclick="deleteTransaction({{ $transaction->id }})"
                            class="text-red-400 hover:text-red-300 text-sm font-medium">
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