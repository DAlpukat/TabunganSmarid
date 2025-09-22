<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Catatan Keuangan') }}
        </h2>
    </x-slot>

    <style>
        /* Gradient Background */
        .gradient-bg {
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5530 100%);
            min-height: 100vh;
            position: relative;
            z-index: 1; /* Pastikan di belakang modal */
        }

        /* Card Styles */
        .glass-card {
            background: rgba(22, 101, 52, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            backdrop-filter: blur(15px);
            border-radius: 16px;
            position: relative;
            z-index: 2;
        }

        .stat-card {
            background: rgba(22, 101, 52, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.3);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(22, 101, 52, 0.3);
            background: rgba(22, 101, 52, 0.3);
        }

        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, #059669, #34d399);
            border: none;
            border-radius: 8px;
            color: #065f46;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
            position: relative;
            z-index: 2;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
            background: linear-gradient(135deg, #047857, #10b981);
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fecaca;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.4);
            border-color: rgba(239, 68, 68, 0.6);
        }

        /* Table Styles */
        .glass-table {
            background: rgba(22, 101, 52, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            backdrop-filter: blur(15px);
            border-radius: 16px;
            position: relative;
            z-index: 2;
        }

        .table-header {
            background: rgba(22, 101, 52, 0.3) !important;
            border-bottom: 1px solid rgba(34, 197, 94, 0.3);
        }

        .table-row {
            border-bottom: 1px solid rgba(34, 197, 94, 0.1);
            transition: all 0.3s ease;
        }

        .table-row:hover {
            background: rgba(22, 101, 52, 0.2);
        }

        /* Notification */
        .success-notification {
            background: rgba(22, 101, 52, 0.3);
            border: 1px solid rgba(34, 197, 94, 0.3);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            position: relative;
            z-index: 5; /* Lebih tinggi dari konten */
        }

        /* Text Colors */
        .text-green-gradient {
            background: linear-gradient(135deg, #34d399, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-red-gradient {
            background: linear-gradient(135deg, #f87171, #ef4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }

        .animate-slideIn {
            animation: slideIn 0.3s ease-out;
        }

        /* Modal Styles */
        .glass-modal {
            background: rgba(22, 101, 52, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.3);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            position: relative;
            z-index: 100; /* Sangat tinggi untuk modal */
        }

        /* Pattern Overlay */
        .pattern-overlay {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(34, 197, 94, 0.1) 2px, transparent 2px),
                radial-gradient(circle at 75% 75%, rgba(34, 197, 94, 0.05) 1px, transparent 1px);
            background-size: 40px 40px, 20px 20px;
            opacity: 0.3;
        }

        /* Z-index fixes */
        .z-content {
            position: relative;
            z-index: 2;
        }

        .z-modal {
            position: fixed;
            z-index: 1000;
        }

        .z-toast {
            position: fixed;
            z-index: 1001;
        }
    </style>

    <div class="gradient-bg py-12 relative">
        <div class="absolute inset-0 pattern-overlay"></div>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <!-- Success Notification -->
            @if(session('success'))
                <div id="success-notification" class="success-notification mb-6 p-4 text-green-300 animate-fadeInUp relative z-50">
                    <button onclick="closeNotification('success-notification')" class="absolute top-3 right-3 text-green-300 hover:text-green-100 text-lg font-bold">
                        &times;
                    </button>
                    <div class="flex items-center">
                        <div class="w-5 h-5 bg-green-500 rounded-full mr-3"></div>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 z-content">
                <!-- Pemasukan -->
                <div class="stat-card p-6 text-white animate-fadeInUp" style="animation-delay: 0.1s">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium">Total Pemasukan</h3>
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </div>
                    </div>
                    <p id="total-pemasukan" class="text-2xl font-bold text-green-300">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                </div>

                <!-- Pengeluaran -->
                <div class="stat-card p-6 text-white animate-fadeInUp" style="animation-delay: 0.2s">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium">Total Pengeluaran</h3>
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m0 0l-4-4m4 4l4-4"></path>
                            </svg>
                        </div>
                    </div>
                    <p id="total-pengeluaran" class="text-2xl font-bold text-red-300">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                </div>

                <!-- Saldo -->
                <div class="stat-card p-6 text-white animate-fadeInUp" style="animation-delay: 0.3s">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium">Saldo</h3>
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p id="saldo" class="text-2xl font-bold text-blue-300">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Tabel Transaksi -->
            <div class="glass-card overflow-hidden animate-fadeInUp z-content" style="animation-delay: 0.4s">
                <div class="p-6 text-white">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Riwayat Transaksi</h3>
                        <a href="{{ route('transactions.create') }}" class="btn-primary px-6 py-3">
                            + Tambah Transaksi
                        </a>
                    </div>
                    
                    @if($transactions->isEmpty())
                        <p class="text-gray-300 text-center py-8">Belum ada transaksi.</p>
                    @else
                        <div class="overflow-x-auto">
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
                                    @foreach($transactions as $transaction)
                                    <tr id="transaction-{{ $transaction->id }}" class="table-row">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                            {{ $transaction->formatted_date }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $transaction->type === 'pemasukan' ? 'bg-green-500/20 text-green-300 border border-green-500/30' : 'bg-red-500/20 text-red-300 border border-red-500/30' }}">
                                                {{ ucfirst($transaction->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold 
                                            {{ $transaction->type === 'pemasukan' ? 'text-green-300' : 'text-red-300' }}">
                                            {{ $transaction->formatted_amount }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                            {{ $transaction->description ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="btn-delete delete-btn px-3 py-2 rounded-md text-xs" 
                                                    data-id="{{ $transaction->id }}">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
            <!-- Kotak Saran -->
            <div class="mt-8 glass-card p-6 z-content">
                <h3 class="text-lg font-medium text-[#e1d5b5] mb-4">Kotak Saran</h3>

                <form action="{{ route('suggestions.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-[#e1d5b5]">Nama (opsional)</label>
                            <input type="text" name="name" id="name" 
                                class="mt-1 block w-full rounded-md border border-[rgba(225,213,181,0.3)] bg-[rgba(21,47,48,0.5)] text-[#e1d5b5] shadow-sm 
                                    focus:border-[#e1d5b5] focus:ring-[#e1d5b5] sm:text-sm 
                                    px-3 py-2"
                                placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-[#e1d5b5]">Email (opsional)</label>
                            <input type="email" name="email" id="email" 
                                class="mt-1 block w-full rounded-md border border-[rgba(225,213,181,0.3)] bg-[rgba(21,47,48,0.5)] text-[#e1d5b5] shadow-sm 
                                    focus:border-[#e1d5b5] focus:ring-[#e1d5b5] sm:text-sm 
                                    px-3 py-2"
                                placeholder="Masukkan email Anda">
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-[#e1d5b5]">Saran Anda</label>
                        <textarea name="message" id="message" rows="4"
                            class="mt-1 block w-full rounded-md border border-[rgba(225,213,181,0.3)] bg-[rgba(21,47,48,0.5)] text-[#e1d5b5] shadow-sm 
                                focus:border-[#e1d5b5] focus:ring-[#e1d5b5] sm:text-sm 
                                px-3 py-2"
                            placeholder="Tuliskan saran Anda di sini..."></textarea>
                    </div>

                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-[rgba(225,213,181,0.2)] border border-[rgba(225,213,181,0.3)] rounded-md 
                                font-semibold text-xs text-[#e1d5b5] uppercase tracking-widest hover:bg-[rgba(225,213,181,0.3)] 
                                focus:bg-[rgba(225,213,181,0.3)] active:bg-[rgba(225,213,181,0.4)] focus:outline-none focus:ring-2 
                                focus:ring-[#e1d5b5] focus:ring-offset-2 transition ease-in-out duration-150">
                            Kirim
                        </button>
                    </div>
                </form>
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
                            // Tampilkan notifikasi sukses
                            showToast(response.message, 'success');
                        });
                    } else {
                        showToast('Gagal menghapus transaksi.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
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

        // Fungsi untuk memformat angka (tanpa desimal)
        function formatNumber(number) {
            const integerNumber = Math.round(number);
            return integerNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        // Fungsi untuk menampilkan toast notifikasi
        function showToast(message, type = 'success') {
            // Hapus toast sebelumnya jika ada
            $('.toast-message').remove();
            
            const toast = document.createElement('div');
            toast.className = `animate-slideIn p-4 rounded-lg shadow-lg flex items-center glass-effect border z-toast ${
                type === 'success' ? 'border-green-500/30 text-green-300' : 
                'border-red-500/30 text-red-300'
            }`;
            toast.innerHTML = `
                <span class="flex-1 toast-message">${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-4 text-current hover:opacity-70 text-lg">
                    &times;
                </button>
            `;
            
            document.getElementById('toast-container').appendChild(toast);
            
            // Sembunyikan otomatis setelah 3 detik
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 3000);
        }

        // Fungsi untuk menyembunyikan toast
        function hideToast() {
            $('.toast-message').remove();
        }
    });

    // Fungsi untuk menutup notifikasi success
    function closeNotification(notificationId) {
        const notification = document.getElementById(notificationId);
        if (notification) {
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 300);
        }
    }

    // Auto-close notifikasi setelah 5 detik
    document.addEventListener('DOMContentLoaded', function() {
        const notification = document.getElementById('success-notification');
        if (notification) {
            setTimeout(() => {
                closeNotification('success-notification');
            }, 5000);
        }
    });
    </script>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 items-center flex justify-center z-modal hidden">
        <div class="glass-modal p-6 w-full max-w-md animate-slideIn">
            <h3 class="text-lg font-medium text-green-300 mb-4">Konfirmasi Hapus</h3>
            <p class="text-gray-300 mb-6">Apakah Anda yakin ingin menghapus transaksi ini?</p>
            <div class="flex justify-end space-x-3">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-600 text-gray-200 rounded-md hover:bg-gray-500 transition">
                    Batal
                </button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast-container" class="fixed top-4 right-4 z-toast space-y-3"></div>

</x-app-layout>