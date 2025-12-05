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


        /* PROSE CUSTOM — INI YANG BIKIN TEKS PANJANG AUTO ENTER + GA KELUAR KOTAK */
        .prose-custom {
            color: #e1d5b5;
            max-width: 100%;
            line-height: 1.8;
        }

        .prose-custom p, 
        .prose-custom h1, 
        .prose-custom h2, 
        .prose-custom h3, 
        .prose-custom h4, 
        .prose-custom ul, 
        .prose-custom ol {
            margin-bottom: 1.2rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .prose-custom img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 1.5rem 0;
        }

        .prose-custom a {
            color: #34d399;
            text-decoration: underline;
            font-weight: 600;
        }

        .prose-custom a:hover {
            color: #10b981;
        }

        /* Mobile fix ekstra */
        @media (max-width: 640px) {
            .prose-custom {
                font-size: 0.95rem;
            }
        }

        /* TEXT RATA KANAN KIRI (JUSTIFY) KAYAK KTI/WORD/GDOCS */
        .justify-text {
            text-align: justify !important;
            text-justify: inter-word; /* biar spasi rapi banget */
        }

        /* Khusus paragraf */
        .justify-text p {
            text-align: justify !important;
            text-justify: inter-word;
            margin-bottom: 1.5rem;
        }

        /* Heading tetap center atau left sesuai selera (aku biarin left biar rapi) */
        .justify-text h1, 
        .justify-text h2, 
        .justify-text h3, 
        .justify-text h4 {
            text-align: left !important;
            margin-bottom: 1.2rem;
        }
    </style>

    <div class="gradient-bg py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <div class="glass-card p-6 md:p-8 text-white animate-fadeInUp">
                @if($announcement->image_path)
                    <img src="{{ Storage::url($announcement->image_path) }}" alt="{{ $announcement->title }}" class="w-full h-64 md:h-96 object-cover rounded-md mb-6">
                @endif
                
                <h1 class="text-3xl md:text-4xl font-bold text-green-300 mb-4">{{ $announcement->title }}</h1>
                <p class="text-sm text-gray-400 mb-8">Oleh {{ $announcement->user->name }} • {{ $announcement->created_at->format('d F Y, H:i') }}</p>
                
                <!-- INI YANG BARU — PROSE CUSTOM BIAR RESPONSIF 100% -->
                <div class="prose-custom max-w-none ">
                    {!! $announcement->content !!}
                </div>

                <div class="mt-12">
                    <a href="{{ route('announcements.public.index') }}" class="text-green-400 hover:text-green-300 text-sm font-medium">
                        ← Kembali ke daftar berita
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>