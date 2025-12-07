<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Transaksi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card p-8">
                <form method="POST" action="{{ route('transactions.store') }}" class="space-y-8">
                    @csrf

                    <!-- Jenis Transaksi -->
                    <div>
                        <label for="type" class="block text-lg font-medium text-gray-300 mb-3">
                            Jenis Transaksi
                        </label>
                        <select id="type" name="type" required class="w-full px-6 py-4 rounded-xl bg-gray-800/70 border border-gray-600 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/30 transition-all text-lg">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                            <option value="hutang">Hutang</option>
                        </select>
                    </div>

                    
                    <!-- KATEGORI PENGELUARAN -->
                    <div id="category-field" style="display: none;">
                        <div class="space-y-3">
                            <label for="category" class="block text-lg font-medium text-gray-300">
                                Kategori Pengeluaran <span class="text-blue-400 font-medium">(Opsional - hanya jika sesuai anggaran)</span>
                            </label>

                            @php
                                $budgetCategories = auth()->user()->budgets()
                                    ->where('month', now()->month)
                                    ->where('year', now()->year)
                                    ->orderBy('category')
                                    ->pluck('category')
                                    ->unique()
                                    ->values();
                            @endphp

                            @if($budgetCategories->count() > 0)
                                <select name="category" id="category" class="w-full px-6 py-4 rounded-xl bg-gray-800/70 border border-gray-600 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/30 transition-all text-lg">
                                    <option value="">-- Pilih Kategori (Opsional) --</option>
                                    <option value="">Tanpa Kategori (Pure Pengeluaran)</option>
                                    @foreach($budgetCategories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                                <div class="space-y-2 mt-3">
                                    <p class="text-green-400 text-sm font-medium">
                                        ✓ Jika memilih kategori, pengeluaran akan masuk ke "terpakai" di anggaran
                                    </p>
                                    <p class="text-blue-400 text-sm font-medium">
                                        ✓ Jika tidak memilih kategori, pengeluaran akan dicatat sebagai pure pengeluaran
                                    </p>
                                </div>
                            @else
                                <div class="bg-blue-900/50 border-2 border-blue-500 text-blue-200 px-6 py-5 rounded-xl">
                                    <p class="text-lg font-bold mb-2">Belum ada anggaran bulan ini</p>
                                    <p class="mb-4">Pengeluaran akan dicatat sebagai pure pengeluaran tanpa kategori.</p>
                                    <!-- Tambahkan hidden input untuk kategori kosong -->
                                    <input type="hidden" name="category" value="">
                                    <a href="{{ route('budgets.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg font-medium transition-colors">
                                        Buat Anggaran (Opsional) →
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label for="amount" class="block text-lg font-medium text-gray-300 mb-3">
                            Jumlah (Rp)
                        </label>
                        <input type="number" name="amount" required min="1" placeholder="100000"
                               class="w-full px-6 py-4 rounded-xl bg-gray-800/70 border border-gray-600 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/30 transition-all text-lg">
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label for="date" class="block text-lg font-medium text-gray-300 mb-3">
                            Tanggal Transaksi
                        </label>
                        <input type="date" name="date" required value="{{ old('date', now()->format('Y-m-d')) }}"
                               class="w-full px-6 py-4 rounded-xl bg-gray-800/70 border border-gray-600 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/30 transition-all text-lg">
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="description" class="block text-lg font-medium text-gray-300 mb-3">
                            Deskripsi (Opsional)
                        </label>
                        <textarea name="description" rows="4" placeholder="ex: Bensin motor, belanja bulanan"
                                  class="w-full px-6 py-4 rounded-xl bg-gray-800/70 border border-gray-600 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/30 transition-all text-lg resize-none"></textarea>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end gap-6 pt-8">
                        <a href="{{ route('dashboard') }}" class="px-10 py-4 bg-gray-700 text-gray-300 rounded-xl hover:bg-gray-600 transition-all font-bold text-lg">
                            Batal
                        </a>
                        <button type="submit" class="px-12 py-4 btn-primary text-xl font-bold hover:scale-105 transition-all shadow-xl">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const typeSelect = document.getElementById('type');
        const categoryField = document.getElementById('category-field');

        function toggleCategory() {
            if (typeSelect.value === 'pengeluaran') {
                categoryField.style.display = 'block';
            } else {
                categoryField.style.display = 'none';
            }
        }

        typeSelect.addEventListener('change', toggleCategory);
        toggleCategory();
    </script>
</x-app-layout>