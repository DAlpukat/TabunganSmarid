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
            {{ __('Upload Berita Baru') }}
        </h2>
    </x-slot>

    <!-- Saya akan gunakan style yang sudah ada dari halaman create lainnya -->
    <div class="gradient-bg py-12 relative min-h-screen">
        <div class="absolute inset-0 pattern-overlay"></div>
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <div class="glass-card p-6 md:p-8 text-white animate-fadeInUp">
                <form method="POST" action="{{ route('announcements.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Judul -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-green-300 mb-2">Judul Berita</label>
                        <input type="text" name="title" id="title" required
                            class="w-full rounded-md border border-green-300 bg-transparent text-green-200 px-4 py-2 focus:ring-green-400 focus:border-green-400 transition" />
                        @error('title')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gambar Header -->
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-green-300 mb-2">Gambar Header (Opsional)</label>
                        <input type="file" name="image" id="image" accept="image/*"
                            class="w-full rounded-md border border-green-300 bg-transparent text-green-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700 transition" />
                        @error('image')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konten (Rich Text Editor) -->
                    <div class="mb-6">
                        <label for="content" class="block text-sm font-medium text-green-300 mb-2">Isi Berita</label>
                        <textarea name="content" id="content" class="w-full rounded-md border border-green-300 bg-transparent text-green-200 px-4 py-2 focus:ring-green-400 focus:border-green-400 transition" rows="15"></textarea>
                        @error('content')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('announcements.index') }}" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-md transition">
                            Batal
                        </a>
                        <button type="submit" class="btn-primary px-6 py-3">Simpan Berita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Include TinyMCE dari CDN -->
        <script src="https://cdn.tiny.cloud/1/va4rezvcchgc0ed2bq1t7ik66k2dwozla6g3lcdflc5ib9ek/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            let editor; // Variabel untuk menyimpan instance editor

            tinymce.init({
                selector: 'textarea#content',
                plugins: 'image link lists autolink',
                toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
                menubar: false,
                branding: false,
                height: 500,
                content_style: 'body { background-color: #1a3a32; color: #e1d5b5; }',
                setup: function (editor) {
                    // Simpan instance editor ke variabel global
                    window.editor = editor;
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form');

                if (form) {
                    // Kita menyadap event 'submit' dari form, bukan 'click' dari tombol
                    form.addEventListener('submit', function(event) {
                        console.log('Form submit event detected.');

                        // 1. Cek apakah konten di editor kosong
                        const content = window.editor.getContent();
                        console.log('Content:', content);

                        if (content.trim() === '') {
                            // 2. Jika kosong, hentikan proses submit
                            console.log('Content is empty, preventing submission.');
                            event.preventDefault(); // Hentikan submit
                            showToast('Isi berita tidak boleh kosong.', 'error');
                            window.editor.focus();
                            return; // Keluar dari fungsi
                        }

                        // 3. Jika tidak kosong, sinkronkan konten ke textarea SEBELUM form dikirim
                        console.log('Content is valid, triggering save.');
                        tinymce.triggerSave();
                        
                        // Tidak perlu form.submit() lagi karena kita tidak mencegah defaultnya.
                        // Karena kita tidak memanggil preventDefault() di sini, form akan lanjut submit secara normal.
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>