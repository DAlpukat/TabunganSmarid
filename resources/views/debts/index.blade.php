<x-app-layout>

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
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Daftar Hutang
        </h2>
    </x-slot>

    <div class="gradient-bg py-8 md:py-12 relative min-h-screen">
        <div class="absolute inset-0 pattern-overlay"></div>
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 relative z-10">
            <div class="glass-card overflow-hidden animate-fadeInUp z-content" style="animation-delay: 0.4s">
                <div class="p-4 md:p-6 text-white">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
                        <h3 class="text-lg font-medium">Daftar Hutang</h3>
                        <a href="{{ route('debts.create') }}" class="btn-primary px-4 py-2 md:px-6 md:py-3 text-sm md:text-base w-full md:w-auto text-center">
                            + Tambah Hutang
                        </a>
                    </div>
                    @if($debts->isEmpty())
                        <p class="text-gray-300 text-center py-8">Belum ada hutang.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[600px]">
                                <thead class="table-header">
                                    <tr>
                                        <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-green-300 uppercase tracking-wider">Pemberi Hutang</th>
                                        <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-green-300 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-green-300 uppercase tracking-wider">Jatuh Tempo</th>
                                        <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-green-300 uppercase tracking-wider">Status</th>
                                        <th class="px-3 md:px-6 py-3 text-left text-xs font-medium text-green-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700">
                                    @foreach($debts as $debt)
                                    <tr class="table-row">
                                        <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                            {{ $debt->creditor }}
                                        </td>
                                        <td class="px-3 md:px-6 py-4 whitespace-nowrap font-semibold text-green-300">
                                            {{ $debt->formatted_amount }}
                                        </td>
                                        <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                            {{ $debt->formatted_due_date }}
                                        </td>
                                        <td class="px-3 md:px-6 py-4 whitespace-nowrap">
                                            @if($debt->is_paid)
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500/20 text-green-300 border border-green-500/30">
                                                    Lunas
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500/20 text-red-300 border border-red-500/30">
                                                    Belum Lunas
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if(!$debt->is_paid)
                                            <form action="{{ route('debts.update', $debt) }}" method="POST" class="inline">
                                                @csrf @method('PUT')
                                                <button type="submit" class="btn-primary px-3 py-2 md:px-4 md:py-2 rounded-md text-xs md:text-sm font-semibold shadow hover:scale-105 transition">
                                                    Lunasi
                                                </button>
                                            </form>
                                            @else
                                                <span class="text-green-400 text-xs">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>