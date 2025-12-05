<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Catatan Keuangan') }}
        </h2>
    </x-slot>

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
        .success-notification {
            background: rgba(22, 101, 52, 0.3);
            border: 1px solid rgba(34, 197, 94, 0.3);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            position: relative;
            z-index: 5; 
        }
    </style>

    <div class="gradient-bg py-12 relative">
        <div class="absolute inset-0 pattern-overlay"></div>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="stat-card p-6 text-white">
                    <h3 class="text-lg font-medium">Total Pemasukan</h3>
                    <p id="total-pemasukan" class="text-2xl font-bold text-green-300 mt-2">
                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                    </p>
                </div>
                <div class="stat-card p-6 text-white">
                    <h3 class="text-lg font-medium">Total Pengeluaran</h3>
                    <p id="total-pengeluaran" class="text-2xl font-bold text-red-300 mt-2">
                        Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                    </p>
                </div>
                <!-- SALDO CARD -->
                <div class="stat-card p-6 text-white">
                    <h3 class="text-lg font-medium">Saldo</h3>
                    <div id="saldo-container" class="mt-3 space-y-1">
                        <p class="text-2xl font-bold leading-tight text-blue-300">
                            Rp {{ number_format($saldo + $totalUtang, 0, ',', '.') }}
                        </p>
                        @if($totalUtang > 0)
                            <p class="text-xl font-bold leading-tight text-red-400">
                                (- Rp {{ number_format($totalUtang, 0, ',', '.') }})
                            </p>
                        @endif
                    </div>
                </div>

                <!-- TOTAL UTANG CARD -->
                <div class="stat-card p-6 text-white {{ $totalUtang > 0 ? 'border-red-500/40 bg-red-500/5' : '' }} transition-all duration-300">
                    <h3 class="text-lg font-medium {{ $totalUtang > 0 ? 'text-red-300' : '' }}">Total Utang</h3>
                    <p id="total-utang" class="text-3xl font-bold text-red-400 mt-3 leading-tight">
                        {{ $totalUtang > 0 ? '- Rp ' . number_format($totalUtang, 0, ',', '.') : 'Rp 0' }}
                    </p>
                    <p id="utang-warning" class="text-red-400 text-sm mt-2 opacity-80 animate-pulse {{ $totalUtang > 0 ? '' : 'hidden' }}">
                        ▼ Harus segera dibayar!
                    </p>
                </div>
            </div>

            <!-- Charts dengan skeleton + lazy load -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="glass-card p-6 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-green-300 mb-4">Pemasukan vs Pengeluaran</h3>
                    <div id="barChartSkeleton" class="chart-skeleton"></div>
                    <canvas id="barChart" class="hidden"></canvas>
                </div>
                <div class="glass-card p-6">
                    <h3 class="text-lg font-semibold text-green-300 mb-4">Komposisi Keuangan</h3>
                    <div id="pieChartSkeleton" class="chart-skeleton"></div>
                    <canvas id="pieChart" class="hidden"></canvas>
                </div>
            </div>

            <div class="glass-card p-6 mb-8">
                <h3 class="text-lg font-semibold text-green-300 mb-4">Trend Saldo</h3>
                <div id="lineChartSkeleton" class="chart-skeleton"></div>
                <canvas id="lineChart" class="hidden"></canvas>
            </div>

            <!-- Filter -->
            <div class="glass-card p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="text" id="search" placeholder="Cari deskripsi..." class="px-4 py-2 rounded-lg bg-gray-800/50 border border-gray-700 text-white">
                    <select id="type" class="px-4 py-2 rounded-lg bg-gray-800/50 border border-gray-700 text-white">
                        <option value="">Semua Tipe</option>
                        <option value="pemasukan">Pemasukan</option>
                        <option value="pengeluaran">Pengeluaran</option>
                        <option value="hutang">Hutang</option>
                    </select>
                    <select id="sort_by" class="px-4 py-2 rounded-lg bg-gray-800/50 border border-gray-700 text-white">
                        <option value="date">Tanggal</option>
                        <option value="amount">Jumlah</option>
                    </select>
                    <button id="toggleOrder" class="px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-lg font-medium flex items-center justify-center gap-2">
                        <span id="orderText">DESC</span>
                        <svg id="orderIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                    </button>
                </div>
            </div>

            <!-- Tabel dengan wrapper optimasi scroll -->
            <div class="glass-card overflow-hidden">
                <div class="p-6 text-white">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Riwayat Transaksi</h3>
                        <a href="{{ route('transactions.create') }}" class="btn-primary px-6 py-3">+ Tambah Transaksi</a>
                    </div>

                    <div class="transaction-table-wrapper">
                        <div id="transactionTable">
                            @include('partials.transaction-table')
                        </div>
                    </div>

                    <div id="pagination" class="mt-6">{{ $transactions->links() }}</div>
                </div>
            </div>

            <!-- Kotak Saran (tetap sama) -->
            <div class="mt-8 glass-card p-6">
                <h3 class="text-lg font-medium text-[#e1d5b5] mb-4">Kotak Saran</h3>
                <form action="{{ route('suggestions.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#e1d5b5]">Nama (opsional)</label>
                            <input type="text" name="name" class="mt-1 block w-full rounded-md border border-[rgba(225,213,181,0.3)] bg-[rgba(21,47,48,0.5)] text-[#e1d5b5] px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#e1d5b5]">Email (opsional)</label>
                            <input type="email" name="email" class="mt-1 block w-full rounded-md border border-[rgba(225,213,181,0.3)] bg-[rgba(21,47,48,0.5)] text-[#e1d5b5] px-3 py-2">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#e1d5b5]">Saran Anda</label>
                        <textarea name="message" rows="4" class="mt-1 block w-full rounded-md border border-[rgba(225,213,181,0.3)] bg-[rgba(21,47,48,0.5)] text-[#e1d5b5] px-3 py-2"></textarea>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-[rgba(225,213,181,0.2)] border border-[rgba(225,213,181,0.3)] rounded-md text-[#e1d5b5] hover:bg-[rgba(225,213,181,0.3)]">
                        Kirim
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal & Toast -->
    <div id="deleteModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="glass-modal p-6 w-full max-w-md">
            <h3 class="text-lg font-medium text-green-300 mb-4">Konfirmasi Hapus</h3>
            <p class="text-gray-300 mb-6">Yakin ingin menghapus transaksi ini?</p>
            <div class="flex justify-end gap-3">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-600 text-gray-200 rounded hover:bg-gray-500">Batal</button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
            </div>
        </div>
    </div>

    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-3"></div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let barChart = null, lineChart = null, pieChart = null;
        let currentOrder = 'desc';
        let deleteId = null;
        let isLoading = false;
        let chartsInitialized = false;

        const debounce = (func, delay) => {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => func(...args), delay);
            };
        };

        document.addEventListener('DOMContentLoaded', () => {
            loadTransactions();

            document.getElementById('toggleOrder').addEventListener('click', () => {
                currentOrder = currentOrder === 'desc' ? 'asc' : 'desc';
                document.getElementById('orderText').textContent = currentOrder.toUpperCase();
                document.getElementById('orderIcon').setAttribute('d', currentOrder === 'desc' ? 'M19 9l-7 7-7-7' : 'M5 15l7-7 7 7');
                loadTransactions();
            });

            document.getElementById('search').addEventListener('input', debounce(loadTransactions, 300));
            ['type', 'sort_by'].forEach(id => document.getElementById(id).addEventListener('change', loadTransactions));

            document.getElementById('transactionTable').addEventListener('click', e => {
                const deleteBtn = e.target.closest('.delete-btn');
                if (deleteBtn) {
                    deleteId = deleteBtn.dataset.id;
                    document.getElementById('deleteModal').classList.remove('hidden');
                }
            });
        });

        const chartObserver = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !chartsInitialized) {
                    chartsInitialized = true;
                    initCharts({!! json_encode(['months' => $months, 'pemasukanData' => $pemasukanData, 'pengeluaranData' => $pengeluaranData, 'saldoData' => $saldoData, 'pie' => [$totalPemasukan, $totalPengeluaran, $totalUtang]]) !!});
                    document.querySelectorAll('[id$="ChartSkeleton"]').forEach(el => el.remove());
                    document.querySelectorAll('canvas[id$="Chart"]').forEach(el => el.classList.remove('hidden'));
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('#barChart, #lineChart, #pieChart').forEach(canvas => chartObserver.observe(canvas.parentElement));

        function initCharts(initialData) {
            // Bar Chart
            const ctx1 = document.getElementById('barChart').getContext('2d');
            barChart = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: initialData.months,
                    datasets: [
                        { label: 'Pemasukan', data: initialData.pemasukanData, backgroundColor: 'rgba(34, 197, 94, 0.6)', borderColor: '#22c55e', borderWidth: 2 },
                        { label: 'Pengeluaran', data: initialData.pengeluaranData, backgroundColor: 'rgba(239, 68, 68, 0.6)', borderColor: '#ef4444', borderWidth: 2 }
                    ]
                },
                options: { responsive: true, plugins: { legend: { labels: { color: '#e1d5b5' } } }, scales: { x: { ticks: { color: '#e1d5b5' }, grid: { color: 'rgba(34, 197, 94, 0.2)' } }, y: { ticks: { color: '#e1d5b5' }, grid: { color: 'rgba(34, 197, 94, 0.2)' } } } }
            });

            // Line Chart
            const ctx2 = document.getElementById('lineChart').getContext('2d');
            lineChart = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: initialData.months,
                    datasets: [{
                        label: 'Saldo',
                        data: initialData.saldoData,
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.25)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3
                    }]
                },
                options: { responsive: true, plugins: { legend: { labels: { color: '#e1d5b5' } } }, scales: { x: { ticks: { color: '#e1d5b5' }, grid: { color: 'rgba(34, 197, 94, 0.2)' } }, y: { ticks: { color: '#e1d5b5' }, grid: { color: 'rgba(34, 197, 94, 0.2)' } } } }
            });

            // Pie Chart
            const ctx3 = document.getElementById('pieChart').getContext('2d');
            pieChart = new Chart(ctx3, {
                type: 'doughnut',
                data: {
                    labels: ['Pemasukan Total', 'Pengeluaran Total', 'Utang Belum Lunas'],
                    datasets: [{
                        data: initialData.pie,
                        backgroundColor: ['#22c55e', '#ef4444', '#f59e0b'],
                        borderColor: '#1a3a32',
                        borderWidth: 2
                    }]
                },
                options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { color: '#e1d5b5' } } } }
            });
        }

        function loadTransactions() {
            if (isLoading) return;
            isLoading = true;
            document.getElementById('transactionTable').classList.add('loading');

            const params = new URLSearchParams({
                search: document.getElementById('search').value.trim(),
                type: document.getElementById('type').value,
                sort_by: document.getElementById('sort_by').value,
                order: currentOrder
            });

            fetch(`{{ route('dashboard') }}?${params}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                // Update table & pagination
                document.getElementById('transactionTable').innerHTML = data.table;
                document.getElementById('pagination').innerHTML = data.pagination;

                // Update stat cards
                document.getElementById('total-pemasukan').textContent = data.summary.totalPemasukan;
                document.getElementById('total-pengeluaran').textContent = data.summary.totalPengeluaran;

                // Saldo + Hutang (multi-line)
                const baseSaldo = data.summary.saldo;
                const utangVal = data.summary.totalUtang.replace('Rp ', '').trim();
                const hasUtang = parseInt(utangVal.replace(/\D/g, '') || 0) > 0;

                document.getElementById('saldo-container').innerHTML = `
                    <p class="text-2xl font-bold leading-tight text-blue-300">${baseSaldo}</p>
                    ${hasUtang ? `<p class="text-xl font-bold leading-tight text-red-400">(- Rp ${utangVal})</p>` : ''}
                `;

                // Total Utang
                document.getElementById('total-utang').textContent = hasUtang ? `- Rp ${utangVal}` : 'Rp 0';

                // Border + warning
                const utangCard = document.getElementById('total-utang').closest('.stat-card');
                const warning = document.getElementById('utang-warning');
                if (hasUtang) {
                    utangCard.classList.add('border-red-500/40', 'bg-red-500/5');
                    warning.classList.remove('hidden');
                } else {
                    utangCard.classList.remove('border-red-500/40', 'bg-red-500/5');
                    warning.classList.add('hidden');
                }

                // Update charts kalau sudah di-init
                if (chartsInitialized) {
                    barChart.data.labels = data.chart.months;
                    barChart.data.datasets[0].data = data.chart.pemasukan;
                    barChart.data.datasets[1].data = data.chart.pengeluaran;
                    barChart.update('none');

                    lineChart.data.labels = data.chart.months;
                    lineChart.data.datasets[0].data = data.chart.saldo;
                    lineChart.update('none');

                    pieChart.data.datasets[0].data = data.chart.pie;
                    pieChart.update('none');
                }

                document.getElementById('transactionTable').classList.remove('loading');
                isLoading = false;
            })
            .catch(() => {
                document.getElementById('transactionTable').classList.remove('loading');
                isLoading = false;
                showToast('Gagal memuat transaksi', 'error');
            });
        }

        function deleteTransaction(id) {
            fetch(`/transactions/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(res => {
                showToast(res.message || 'Transaksi berhasil dihapus!', 'success');
                loadTransactions();
            })
            .catch(() => showToast('Gagal menghapus transaksi', 'error'))
            .finally(() => {
                document.getElementById('deleteModal').classList.add('hidden');
                deleteId = null;
            });
        }

        document.getElementById('confirmDelete').onclick = () => deleteId && deleteTransaction(deleteId);
        document.getElementById('cancelDelete').onclick = () => {
            document.getElementById('deleteModal').classList.add('hidden');
            deleteId = null;
        };

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `animate-slideIn p-4 rounded-xl shadow-2xl flex items-center gap-3 border backdrop-blur-md min-w-80 fixed top-4 right-4 z-50 ${type === 'success' ? 'bg-green-950/70 border-green-500/50 text-green-200' : 'bg-red-950/70 border-red-500/50 text-red-200'}`;
            toast.innerHTML = `<span class="flex-1">${message}</span><button onclick="this.parentElement.remove()" class="text-current hover:opacity-70 text-xl">&times;</button>`;
            document.body.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; toast.style.transform = 'translateX(100%)'; setTimeout(() => toast.remove(), 300); }, 3000);
        }

        const notif = document.getElementById('success-notification');
        if (notif) setTimeout(() => { notif.style.opacity = '0'; setTimeout(() => notif.style.display = 'none', 300); }, 5000);
    </script>
</x-app-layout>