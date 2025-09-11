<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Track Keuangan') }}
        </h2>
    </x-slot>

    <style>
        /* Animasi untuk modal */
        #deleteModal {
            transition: opacity 0.3s ease;
        }
        
        #deleteModal:not(.hidden) {
            animation: fadeIn 0.3s ease-out;
        }
        
        #toast {
            transition: all 0.3s ease;
        }
        
        #toast:not(.hidden) {
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            from { 
                opacity: 0;
                transform: translateX(100px);
            }
            to { 
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Pemasukan -->
            <div class="m-3 bg-green-500 dark:bg-green-700 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
                <h3 class="text-lg font-medium mb-2">Total Pemasukan</h3>
                <p id="total-pemasukan" class="text-2xl font-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
            </div>

            <!-- Pengeluaran -->
            <div class="m-3 bg-red-500 dark:bg-red-700 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
                <h3 class="text-lg font-medium mb-2">Total Pengeluaran</h3>
                <p id="total-pengeluaran" class="text-2xl font-bold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
            </div>

            <!-- Saldo -->
            <div class="m-3 bg-blue-500 dark:bg-blue-700 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
                <h3 class="text-lg font-medium mb-2">Saldo</h3>
                <p id="saldo" class="text-2xl font-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
            </div>

            <!-- Tabel Transaksi -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Riwayat Transaksi</h3>
                        <a href="{{ route('transactions.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                            + Tambah Transaksi
                        </a>
                    </div>
                    
                    @if($transactions->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">Belum ada transaksi.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <!-- Di dalam tabel riwayat transaksi, tambahkan kolom aksi -->
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jenis</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($transactions as $transaction)
                                <tr id="transaction-{{ $transaction->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $transaction->formatted_date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $transaction->type === 'pemasukan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm 
                                        {{ $transaction->type === 'pemasukan' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $transaction->formatted_amount }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $transaction->description ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="delete-btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs" 
                                                data-id="{{ $transaction->id }}">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        let selectedTransactionId = null;
        const deleteModal = $('#deleteModal');
        const toast = $('#toast');
        
        // Fungsi untuk menampilkan modal konfirmasi
        $('.delete-btn').click(function() {
            selectedTransactionId = $(this).data('id');
            deleteModal.removeClass('hidden');
        });
        
        // Fungsi untuk membatalkan penghapusan
        $('#cancelDelete').click(function() {
            deleteModal.addClass('hidden');
            selectedTransactionId = null;
        });
        
        // Fungsi untuk mengkonfirmasi penghapusan
        $('#confirmDelete').click(function() {
            if (selectedTransactionId) {
                deleteTransaction(selectedTransactionId);
                deleteModal.addClass('hidden');
            }
        });
        
        // Tutup modal ketika klik di luar area modal
        deleteModal.click(function(e) {
            if (e.target === this) {
                deleteModal.addClass('hidden');
                selectedTransactionId = null;
            }
        });
        
        // Fungsi untuk menghapus transaksi via AJAX
        function deleteTransaction(transactionId) {
            const $row = $('#transaction-' + transactionId);
            
            $.ajax({
                url: '/transactions/' + transactionId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Hapus baris dari tabel
                        $row.fadeOut(300, function() {
                            $(this).remove();
                            // Perbarui ringkasan keuangan
                            updateFinancialSummary(response.newSummary);
                            // Tampilkan notifikasi
                            showToast(response.message, 'success');
                        });
                    } else {
                        showToast('Gagal menghapus transaksi.', 'error');
                    }
                },
                error: function() {
                    showToast('Terjadi kesalahan saat menghapus transaksi.', 'error');
                }
            });
        }

        // Fungsi untuk memperbarui ringkasan keuangan
        function updateFinancialSummary(summary) {
            $('#total-pemasukan').text('Rp ' + formatNumber(summary.totalPemasukan));
            $('#total-pengeluaran').text('Rp ' + formatNumber(summary.totalPengeluaran));
            $('#saldo').text('Rp ' + formatNumber(summary.saldo));
        }

        // Fungsi untuk memformat angka
        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        // Fungsi untuk menampilkan toast notifikasi
        function showToast(message, type = 'success') {
            toast.removeClass('bg-red-500 bg-green-500 hidden');
            toast.addClass(type === 'success' ? 'bg-green-500' : 'bg-red-500');
            $('#toast-message').text(message);
            
            // Sembunyikan otomatis setelah 3 detik
            setTimeout(hideToast, 3000);
        }

        // Fungsi untuk menyembunyikan toast
        function hideToast() {
            toast.addClass('hidden');
        }
    });
    </script>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 items-center flex justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Konfirmasi Hapus</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-6">Apakah Anda yakin ingin menghapus transaksi ini?</p>
            <div class="flex justify-end space-x-3">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                    Batal
                </button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 p-4 rounded-lg shadow-lg hidden z-50">
        <div class="flex items-center">
            <span id="toast-message" class="text-white"></span>
            <button onclick="hideToast()" class="ml-4 text-white">&times;</button>
        </div>
    </div>

</x-app-layout>