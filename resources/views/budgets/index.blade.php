<x-app-layout>
    <div class="gradient-bg py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header yang lebih profesional -->
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
                                
                                <div class="glass-card p-6 rounded-2xl border-2 transition-all duration-300 hover:shadow-xl
                                    {{ $percentage >= 100 ? 'border-red-500 bg-gradient-to-r from-red-900/20 to-red-800/10' : 
                                       ($percentage >= 80 ? 'border-orange-500 bg-gradient-to-r from-orange-900/20 to-orange-800/10' : 
                                       'border-green-500/30 bg-gradient-to-r from-green-900/10 to-green-800/5') }}">
                                    
                                    <!-- Header Kategori -->
                                    <div class="flex justify-between items-start mb-6">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="text-2xl font-bold text-green-300">{{ $budget->category }}</span>
                                                @if($percentage >= 100)
                                                    <span class="bg-red-500/20 text-red-300 px-3 py-1 rounded-full text-sm font-bold animate-pulse">
                                                        OVER LIMIT
                                                    </span>
                                                @elseif($percentage >= 80)
                                                    <span class="bg-orange-500/20 text-orange-300 px-3 py-1 rounded-full text-sm font-bold">
                                                        HAMPIR HABIS
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-4 text-gray-400">
                                                <span class="flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                    Anggaran: Rp {{ number_format($budget->amount, 0, ',', '.') }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Terpakai: {{ number_format($percentage, 1) }}%
                                                </span>
                                            </div>
                                        </div>
                                        <form action="{{ route('budgets.destroy', $budget) }}" method="POST" onsubmit="return confirm('Hapus anggaran {{ $budget->category }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-400 transition-colors p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Progress Bar dengan Detail -->
                                    <div class="space-y-4">
                                        <div>
                                            <div class="flex justify-between text-lg mb-2">
                                                <div>
                                                    <span class="text-gray-300">Terpakai: </span>
                                                    <span class="font-bold {{ $percentage >= 100 ? 'text-red-400' : 'text-green-300' }}">
                                                        Rp {{ number_format($budget->spent, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                                <div class="text-right">
                                                    @if($remaining >= 0)
                                                        <span class="text-gray-300">Sisa: </span>
                                                        <span class="font-bold text-green-300">
                                                            Rp {{ number_format($remaining, 0, ',', '.') }}
                                                        </span>
                                                    @else
                                                        <span class="text-red-300 font-bold">
                                                            Kekurangan: Rp {{ number_format(abs($remaining), 0, ',', '.') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="w-full bg-gray-800 rounded-full h-4 overflow-hidden shadow-inner">
                                                <div class="h-full rounded-full transition-all duration-1000 ease-out relative
                                                    {{ $percentage >= 100 ? 'bg-gradient-to-r from-red-500 to-red-600' : 
                                                       ($percentage >= 80 ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 
                                                       'bg-gradient-to-r from-green-500 to-green-400') }}"
                                                     style="width: {{ min($percentage, 100) }}%">
                                                    @if($percentage >= 80 && $percentage < 100)
                                                        <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="pt-4 border-t border-gray-700">
                                            @if($percentage >= 100)
                                                <div class="text-center">
                                                    <p class="text-red-400 text-xl font-bold animate-pulse flex items-center justify-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        MELEBIHI ANGGARAN
                                                    </p>
                                                    <p class="text-red-300 mt-2">Kurangi pengeluaran atau revisi anggaran</p>
                                                </div>
                                            @elseif($percentage >= 80)
                                                <div class="text-center">
                                                    <p class="text-orange-400 text-lg font-bold flex items-center justify-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                        </svg>
                                                        Hampir Habis
                                                    </p>
                                                    <p class="text-orange-300">Sisa Rp {{ number_format($remaining, 0, ',', '.') }} lagi</p>
                                                </div>
                                            @else
                                                <div class="text-center">
                                                    <p class="text-green-400 text-lg font-bold flex items-center justify-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Masih Aman
                                                    </p>
                                                    <p class="text-gray-300">Sisa dana Rp {{ number_format($remaining, 0, ',', '.') }}</p>
                                                </div>
                                            @endif
                                        </div>
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
                    <div class="glass-card p-8 sticky border-2 {{ $totalBudget - $totalSpent >= 0 ? 'border-green-500/50' : 'border-red-500/50 bg-gradient-to-b from-red-900/10 to-red-800/5' }}">
                        <h2 class="text-2xl font-bold text-green-300 mb-8 flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Ringkasan Bulan Ini
                        </h2>
                        
                        <div class="space-y-8">
                            <!-- Total Anggaran -->
                            <div class="glass-card p-5 border border-green-500/20">
                                <p class="text-gray-400 text-sm mb-1 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    TOTAL ANGGARAN
                                </p>
                                <p class="text-3xl font-bold text-green-300">
                                    Rp {{ number_format($totalBudget, 0, ',', '.') }}
                                </p>
                                <p class="text-gray-400 text-sm mt-2">{{ $budgets->count() }} kategori anggaran</p>
                            </div>
                            
                            <!-- Total Terpakai -->
                            <div class="glass-card p-5 border border-orange-500/20">
                                <p class="text-gray-400 text-sm mb-1 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    TOTAL TERPAKAI
                                </p>
                                <p class="text-3xl font-bold {{ $totalSpent > $totalBudget ? 'text-red-400' : 'text-orange-300' }}">
                                    Rp {{ number_format($totalSpent, 0, ',', '.') }}
                                </p>
                                <p class="text-gray-400 text-sm mt-2">
                                    {{ $totalBudget > 0 ? number_format(($totalSpent / $totalBudget) * 100, 1) : '0' }}% dari total anggaran
                                </p>
                            </div>
                            
                            <!-- Saldo Anggaran -->
                            <div class="glass-card p-5 border {{ $totalBudget - $totalSpent >= 0 ? 'border-green-500/30' : 'border-red-500/30' }}">
                                <p class="text-gray-400 text-sm mb-1 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    SALDO ANGGARAN
                                </p>
                                @php
                                    $balance = $totalBudget - $totalSpent;
                                @endphp
                                
                                @if($balance >= 0)
                                    <p class="text-4xl font-bold text-green-300">
                                        Rp {{ number_format($balance, 0, ',', '.') }}
                                    </p>
                                    <div class="flex items-center gap-2 mt-3 text-green-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                        </svg>
                                        <span class="font-medium">Masih tersedia</span>
                                    </div>
                                    <p class="text-gray-400 text-sm mt-2">Anggaran bulan ini masih aman</p>
                                @else
                                    <p class="text-4xl font-bold text-red-400">
                                        - Rp {{ number_format(abs($balance), 0, ',', '.') }}
                                    </p>
                                    <div class="flex items-center gap-2 mt-3 text-red-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                        </svg>
                                        <span class="font-bold">MELEBIHI ANGGARAN</span>
                                    </div>
                                    <p class="text-red-300 text-sm mt-2">Anda telah melebihi anggaran bulan ini</p>
                                @endif
                            </div>
                        </div>

                        <!-- Tips -->
                        <div class="mt-10 pt-6 border-t border-gray-700">
                            <p class="text-gray-400 text-sm mb-3">💡 Tips:</p>
                            <ul class="space-y-2 text-sm text-gray-300">
                                <li class="flex items-start gap-2">
                                    <span class="text-green-400">✓</span>
                                    <span>Periksa anggaran sebelum melakukan pengeluaran besar</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-400">✓</span>
                                    <span>Gunakan kategori yang konsisten</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-400">✓</span>
                                    <span>Review anggaran di tengah bulan</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>