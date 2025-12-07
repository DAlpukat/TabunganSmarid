<x-app-layout>
    <div class="gradient-bg py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card p-8 mb-8 text-center border border-green-500/30">
                <h1 class="text-4xl font-bold text-green-300 mb-3 flex items-center justify-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Anggaran {{ now()->translatedFormat('F Y') }}
                </h1>
                <p class="text-xl text-gray-300">Kelola pengeluaran dengan bijak untuk masa depan yang lebih baik 🌟</p>
            </div>

            <!-- Informasi Penting -->
            <div class="glass-card p-6 mb-8 border border-yellow-500/50 bg-yellow-900/20">
                <div class="flex items-start gap-4">
                    <div class="text-yellow-400 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-yellow-300 font-bold text-lg mb-2">
                            ⚠️ Pengeluaran hanya terhitung jika kategori sama persis dengan di bawah!
                        </p>
                        <p class="text-yellow-200">
                            Contoh: "Makan" ≠ "Makanan", "Transport" ≠ "Transportasi"
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Daftar Anggaran -->
                <div class="lg:col-span-2">
                    <div class="glass-card p-6">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-2xl font-bold text-green-300 flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Daftar Anggaran
                            </h2>
                            <span class="text-gray-400 text-lg">
                                {{ $budgets->count() }} kategori
                            </span>
                        </div>

                        <!-- Form Tambah Anggaran -->
                        <form action="{{ route('budgets.store') }}" method="POST" class="mb-10 glass-card p-5 border border-green-500/20">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <input type="text" name="category" placeholder="Contoh: Makan, Transport, Hiburan" 
                                           required class="w-full px-5 py-3 rounded-xl bg-gray-800/70 border border-gray-600 text-white placeholder-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-500/30 transition-all">
                                    <p class="text-gray-400 text-sm mt-2">Gunakan nama yang konsisten</p>
                                </div>
                                
                                <div>
                                    <input type="number" name="amount" placeholder="Anggaran (Rp)" 
                                           required class="w-full px-5 py-3 rounded-xl bg-gray-800/70 border border-gray-600 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/30 transition-all">
                                    <p class="text-gray-400 text-sm mt-2">Minimal Rp 10.000</p>
                                </div>
                                
                                <button type="submit" class="btn-primary px-8 py-3 text-lg font-bold hover:scale-105 transition-all flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah Anggaran
                                </button>
                            </div>
                        </form>

                        <!-- List Anggaran -->
                        <div class="space-y-6">
                            @forelse($budgets as $budget)
                                @php
                                    $remaining = $budget->amount - $budget->spent;
                                    $percentage = $budget->percentage;
                                @endphp
                                
                                <div class="glass-card p-6 rounded-2xl border-4 transition-all duration-500 hover:scale-105
                                    {{ $remaining < 0 ? 'border-red-600 shadow-2xl shadow-red-500/30' : 
                                       ($remaining == 0 ? 'border-orange-600 shadow-2xl shadow-orange-500/40' : 
                                       'border-green-500/40') }}">

                                    <!-- Header Kategori -->
                                    <div class="flex justify-between items-start mb-6">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="text-3xl font-black text-green-300">{{ $budget->category }}</span>
                                                @if($remaining < 0)
                                                    <span class="bg-red-600 text-white px-4 py-2 rounded-full text-lg font-black animate-pulse">
                                                        LIMIT!!
                                                    </span>
                                                @elseif($remaining == 0)
                                                    <span class="bg-orange-600 text-white px-4 py-2 rounded-full text-lg font-black animate-pulse">
                                                        HABIS TOTAL
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-6 text-gray-300 text-lg">
                                                <span>Anggaran: <strong class="text-green-300">Rp {{ number_format($budget->amount, 0, ',', '.') }}</strong></span>
                                                <span>Terpakai: <strong class="{{ $percentage >= 100 ? 'text-red-400' : 'text-orange-300' }}">{{ number_format($percentage, 1) }}%</strong></span>
                                            </div>
                                        </div>
                                        <form action="{{ route('budgets.destroy', $budget) }}" method="POST" onsubmit="return confirm('Hapus anggaran {{ $budget->category }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-400 transition-colors p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="mb-6">
                                        <div class="flex justify-between text-xl font-bold mb-3">
                                            <span class="text-green-300">Rp {{ number_format($budget->spent, 0, ',', '.') }}</span>
                                            <span class="{{ $remaining >= 0 ? 'text-green-300' : 'text-red-400' }}">
                                                {{ $remaining >= 0 ? 'Sisa Rp ' . number_format($remaining, 0, ',', '.') : 'Over Rp ' . number_format(abs($remaining), 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-800 rounded-full h-6 overflow-hidden shadow-inner">
                                            <div class="h-full rounded-full transition-all duration-1000 ease-out relative flex items-center justify-end pr-4 text-white font-bold text-lg
                                                {{ $remaining < 0 ? 'bg-gradient-to-r from-red-600 to-red-700' : 
                                                   ($remaining == 0 ? 'bg-gradient-to-r from-orange-600 to-orange-700' : 
                                                   'bg-gradient-to-r from-green-500 to-green-400') }}"
                                                 style="width: {{ min($percentage, 100) }}%">
                                                @if($remaining == 0 || $remaining < 0)
                                                    <span class="animate-pulse">!!</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center py-6 border-t-2 border-gray-700">
                                        @if($remaining == 0)
                                            <p class="text-3xl font-black text-orange-500 animate-pulse tracking-wider">
                                                JANGAN SPENDING LAGI DI KATEGORI INI! 😤
                                            </p>
                                            <p class="text-orange-300 text-lg mt-2">Limit {{ $budget->category }} sudah habis total. Tahan diri!</p>
                                        @elseif($remaining < 0)
                                            <p class="text-5xl font-black text-red-500 animate-pulse tracking-widest drop-shadow-lg">
                                                LIMIT!! 🚨🚨🚨
                                            </p>
                                            <p class="text-red-400 text-2xl font-bold mt-3">
                                                Over Rp {{ number_format(abs($remaining), 0, ',', '.') }}
                                            </p>
                                            <p class="text-red-300 text-lg">Kamu boros banget. Serius, stop dulu belanja di {{ strtolower($budget->category) }}!</p>
                                        @else
                                            <p class="text-green-400 text-xl font-bold flex items-center justify-center gap-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Masih Aman • Sisa Rp {{ number_format($remaining, 0, ',', '.') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-16 glass-card rounded-2xl border-2 border-dashed border-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <h3 class="text-xl font-bold text-gray-400 mb-2">Belum ada anggaran</h3>
                                    <p class="text-gray-500 max-w-md mx-auto">
                                        Mulai buat anggaran untuk mengontrol pengeluaran bulanan Anda
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Bulan Ini -->
                <div class="lg:col-span-1">
                    <div class="glass-card p-8 sticky top-6 border-4 {{ $totalBudget - $totalSpent >= 0 ? 'border-green-500/50' : 'border-red-600 shadow-2xl shadow-red-500/40' }}">
                        <h2 class="text-3xl font-black text-green-300 mb-8 text-center">
                            Ringkasan Bulan Ini
                        </h2>
                        
                        <div class="space-y-8">
                            <div class="text-center">
                                <p class="text-gray-400 text-lg">Total Anggaran</p>
                                <p class="text-4xl font-black text-green-300">Rp {{ number_format($totalBudget, 0, ',', '.') }}</p>
                            </div>
                            
                            <div class="text-center">
                                <p class="text-gray-400 text-lg">Total Terpakai</p>
                                <p class="text-4xl font-black {{ $totalSpent > $totalBudget ? 'text-red-400' : 'text-orange-300' }}">
                                    Rp {{ number_format($totalSpent, 0, ',', '.') }}
                                </p>
                            </div>

                            @php $saldoAnggaran = $totalBudget - $totalSpent; @endphp

                            <div class="text-center py-8 rounded-2xl {{ $saldoAnggaran >= 0 ? 'bg-green-900/30' : 'bg-red-900/40' }}">
                                @if($saldoAnggaran > 0)
                                    <p class="text-5xl font-black text-green-400">Rp {{ number_format($saldoAnggaran, 0, ',', '.') }}</p>
                                    <p class="text-green-300 text-xl mt-3">Masih Aman Bro ✓</p>
                                @elseif($saldoAnggaran == 0)
                                    <p class="text-5xl font-black text-orange-500 animate-pulse">JANGAN SPENDING LAGI BULAN INI!</p>
                                    <p class="text-orange-300 text-xl mt-4">Anggaran pas-pasan habis. Tahan nafsu belanja!</p>
                                @else
                                    <p class="text-6xl font-black text-red-500 animate-pulse tracking-widest drop-shadow-2xl">
                                        LIMIT!! 🚨
                                    </p>
                                    <p class="text-red-400 text-3xl font-bold mt-4">
                                        Over Rp {{ number_format(abs($saldoAnggaran), 0, ',', '.') }}
                                    </p>
                                    <p class="text-red-300 text-lg mt-3">Kamu boros parah bulan ini. Serius nyesel nanti.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Tips -->
                        <div class="mt-10 pt-8 border-t-2 border-gray-700">
                            <p class="text-gray-400 text-sm mb-4 text-center font-bold">💀 MONETIX NGOMONG:</p>
                            <ul class="space-y-3 text-gray-300 text-center">
                                <li class="flex items-center justify-center gap-2"><span class="text-green-400 text-2xl">✓</span> <span>Konsisten kategori = akurat tracking</span></li>
                                <li class="flex items-center justify-center gap-2"><span class="text-green-400 text-2xl">✓</span> <span>Cek anggaran sebelum gesek kartu</span></li>
                                <li class="flex items-center justify-center gap-2"><span class="text-green-400 text-2xl">✓</span> <span>Over budget = malu sama MONETIX</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>