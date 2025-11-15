<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>DEGODEGA - Financial Tracker</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />

        <!-- Meta Tags -->
        <meta name="description" content="Aplikasi manajemen keuangan pribadi oleh DEGODEGA">
        <meta name="keywords" content="keuangan, finansial, pemasukan, pengeluaran, budget">
        <meta name="author" content="DADF Team">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>

            /* --- Streak Animation (Hanya saat aktif) --- */
            .flame-active {
                animation: flicker 1.5s infinite alternate;
                filter: drop-shadow(0 0 8px rgba(251, 146, 60, 0.7));
            }

            @keyframes flicker {
                from {
                    filter: drop-shadow(0 0 5px rgba(251, 146, 60, 0.7));
                }
                to {
                    filter: drop-shadow(0 0 15px rgba(251, 146, 60, 0.9));
                }
            }

            /* Global Styles */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Instrument Sans', sans-serif;
                background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5530 100%);
                color: #e1d5b5;
                min-height: 100vh;
                position: relative;
                overflow-x: hidden;
            }

            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: 
                    radial-gradient(circle at 20% 80%, rgba(22, 101, 52, 0.3) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(5, 46, 22, 0.4) 0%, transparent 50%),
                    radial-gradient(circle at 40% 40%, rgba(34, 85, 48, 0.2) 0%, transparent 50%);
                z-index: -2;
            }

            /* Floating Particles */
            .floating-particles {
                position: fixed;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: -1;
            }

            .particle {
                position: absolute;
                background: rgba(225, 213, 181, 0.1);
                border-radius: 50%;
                animation: float 6s infinite ease-in-out;
            }

            .particle:nth-child(1) { left: 10%; top: 20%; width: 8px; height: 8px; animation-delay: 0s; }
            .particle:nth-child(2) { left: 70%; top: 60%; width: 12px; height: 12px; animation-delay: 2s; }
            .particle:nth-child(3) { left: 30%; top: 80%; width: 6px; height: 6px; animation-delay: 4s; }
            .particle:nth-child(4) { left: 80%; top: 30%; width: 10px; height: 10px; animation-delay: 1s; }
            .particle:nth-child(5) { left: 50%; top: 10%; width: 7px; height: 7px; animation-delay: 3s; }

            /* Glass Effect - Diperbaiki untuk z-index */
            .glass-effect {
                background: rgba(21, 47, 48, 0.95);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(225, 213, 181, 0.2);
                box-shadow: 
                    0 20px 40px rgba(0, 0, 0, 0.3),
                    0 0 0 1px rgba(225, 213, 181, 0.1);
                position: relative;
                z-index: 30;
            }

            /* Gradient Text */
            .gradient-text {
                background: linear-gradient(135deg, #e1d5b5, #d2c39a);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            }

            /* HEADER STYLE ASLI (Seperti sebelumnya) */
            .bg-white {
                background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5530 100%) !important;
            }
            
            .dark\\:bg-gray-800 {
                background: rgba(21, 47, 48, 0.95) !important;
                backdrop-filter: blur(20px);
            }
            
            .border-gray-100 {
                border-color: rgba(225, 213, 181, 0.2) !important;
            }
            
            .dark\\:border-gray-700 {
                border-color: rgba(225, 213, 181, 0.3) !important;
            }
            
            .text-gray-800 {
                color: #e1d5b5 !important;
            }
            
            .dark\\:text-gray-200 {
                color: #e1d5b5 !important;
            }
            
            .leading-tight {
                line-height: 1.25 !important;
            }

            /* Footer khusus - gradient blend yang lebih baik */
            .footer-blend {
                background: linear-gradient(
                    to top,
                    rgba(15, 32, 39, 0.9) 0%,
                    rgba(32, 58, 67, 0.85) 50%,
                    rgba(44, 85, 48, 0.8) 100%
                );
                backdrop-filter: blur(15px);
                border-top: 1px solid rgba(225, 213, 181, 0.3);
            }

            /* Main content area dengan gradient yang smooth */
            .main-content-blend {
                background: linear-gradient(
                    135deg,
                    rgba(15, 32, 39, 0.7) 0%,
                    rgba(32, 58, 67, 0.6) 50%,
                    rgba(44, 85, 48, 0.5) 100%
                );
                min-height: calc(100vh - 200px);
            }

            /* Loading animation */
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.5; }
            }

            .animate-pulse {
                animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(180deg); }
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(50px) scale(0.95);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: rgba(21, 47, 48, 0.5);
            }

            ::-webkit-scrollbar-thumb {
                background: rgba(225, 213, 181, 0.3);
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: rgba(225, 213, 181, 0.5);
            }

            /* Pattern overlay */
            .pattern-overlay {
                background-image: 
                    radial-gradient(circle at 25% 25%, rgba(34, 197, 94, 0.1) 2px, transparent 2px),
                    radial-gradient(circle at 75% 75%, rgba(34, 197, 94, 0.05) 1px, transparent 1px);
                background-size: 40px 40px, 20px 20px;
                opacity: 0.2;
            }

            /* Z-index fix untuk dropdown */
            .z-dropdown {
                z-index: 50 !important;
            }

            .z-header {
                z-index: 40 !important;
            }

            .z-main {
                z-index: 10 !important;
            }

            .z-footer {
                z-index: 20 !important;
            }
        </style>

        <!-- Additional CSS for specific pages -->
        @stack('styles')
    </head>
    <body class="min-h-screen">
        <!-- Floating Particles -->
        <div class="floating-particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>

        <!-- Loading indicator -->
        <div id="loading" class="fixed inset-0 bg-[#0f2027] flex items-center justify-center z-50 transition-opacity duration-300 hidden">
            <div class="text-center">
                <div class="w-16 h-16 border-4 border-[#e1d5b5] border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                <p class="text-[#e1d5b5]">Loading...</p>
            </div>
        </div>

        <div class="min-h-screen flex flex-col relative">
            <!-- Navigation - Pastikan z-index tinggi -->
            <div class="z-dropdown">
                @include('layouts.navigation')
            </div>

            <!-- Page Heading - KEMBALI KE STYLE ASLI -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow z-header">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ $header }}
                        </h2>
                        @isset($subheader)
                            <p class="text-sm text-[#d2c39a] mt-2 opacity-80">
                                {{ $subheader }}
                            </p>
                        @endisset
                    </div>
                </header>
            @endisset

            <!-- Page Content - Diperbaiki gradient blend -->
            <main class="flex-1 relative py-8 z-main">
                <!-- Background pattern -->
                <div class="absolute inset-0 pattern-overlay"></div>
                
                <div class="relative z-10 main-content-blend rounded-lg mx-4">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>

            <!-- Footer - Diperbaiki gradient blend -->
            <footer class="footer-blend border-t border-[rgba(225,213,181,0.3)] mt-auto z-footer">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="text-center md:text-left mb-4 md:mb-0">
                            <p class="text-sm text-[#e1d5b5] opacity-80">
                                &copy; {{ date('Y') }} <span class="gradient-text font-bold">DEGODEGA</span>. All rights reserved.
                            </p>
                            <p class="text-xs text-[#d2c39a] opacity-60 mt-1">
                                Built with ❤️ by Team DADF
                            </p>
                        </div>
                        
                        <div class="flex items-center space-x-6">
                            <a href="https://wa.me/085386605967" class="text-sm text-[#e1d5b5] hover:text-[#d2c39a] transition-colors opacity-80 hover:opacity-100">
                                Beri Saran
                            </a>
                            <a href="https://smaridasa.com" target="_blank" class="text-sm text-[#e1d5b5] hover:text-[#d2c39a] transition-colors opacity-80 hover:opacity-100">
                                Support
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Toast Notification Container -->
        <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-3"></div>

        <script>
            
            document.addEventListener('DOMContentLoaded', function() {
                const streakCountElement = document.getElementById('streakCount');
                const streakCountMobileElement = document.getElementById('streakCountMobile'); // Untuk mobile

                /**
                 * Fungsi untuk menganimasikan angka dari start ke end.
                 */
                function animateValue(element, start, end, duration) {
                    if (start === end) return; // Tidak perlu animasi jika sama
                    let startTimestamp = null;
                    const step = (timestamp) => {
                        if (!startTimestamp) startTimestamp = timestamp;
                        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                        const currentValue = Math.floor(progress * (end - start) + start);
                        element.textContent = currentValue;
                        if (progress < 1) {
                            window.requestAnimationFrame(step);
                        }
                    };
                    window.requestAnimationFrame(step);
                }

                /**
                 * Fungsi untuk memulai animasi streak.
                 */
                function runStreakAnimation() {
                    if (!streakCountElement) return;

                    const currentStreak = parseInt(streakCountElement.textContent, 10) || 0;
                    const previousStreak = parseInt(localStorage.getItem('previousStreak') || '0', 10);

                    // Jika streak bertambah, jalankan animasi
                    if (currentStreak > previousStreak) {
                        animateValue(streakCountElement, previousStreak, currentStreak, 1200); // 1.2 detik
                        if (streakCountMobileElement) {
                            animateValue(streakCountMobileElement, previousStreak, currentStreak, 1200);
                        }
                    }

                    // Simpan streak saat ini untuk perbandingan di kunjungan berikutnya
                    localStorage.setItem('previousStreak', currentStreak.toString());
                }

                // Jalankan animasi saat halaman dimuat
                runStreakAnimation();
            });

            // Enhanced loading management
            document.addEventListener('DOMContentLoaded', function() {
                // Hide loading indicator
                const loadingElement = document.getElementById('loading');
                if (loadingElement) {
                    setTimeout(() => {
                        loadingElement.classList.add('hidden');
                    }, 500);
                }

                // Toast notification function
                window.showToast = function(message, type = 'success', duration = 5000) {
                    const toast = document.createElement('div');
                    toast.className = `animate-slideIn p-4 rounded-lg shadow-lg flex items-center glass-effect border ${
                        type === 'success' ? 'border-green-500/30 text-green-300' : 
                        type === 'error' ? 'border-red-500/30 text-red-300' : 
                        type === 'warning' ? 'border-yellow-500/30 text-yellow-300' : 
                        'border-blue-500/30 text-blue-300'
                    }`;
                    
                    toast.innerHTML = `
                        <span class="flex-1">${message}</span>
                        <button onclick="this.parentElement.remove()" class="ml-4 text-current hover:opacity-70 text-lg">
                            &times;
                        </button>
                    `;
                    
                    document.getElementById('toast-container').appendChild(toast);
                    
                    setTimeout(() => {
                        if (toast.parentElement) {
                            toast.remove();
                        }
                    }, duration);
                };

                // Auto-dismiss alerts
                const alerts = document.querySelectorAll('[x-data="{ show: true }"]');
                alerts.forEach(alert => {
                    setTimeout(() => {
                        if (alert.parentElement) {
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 300);
                        }
                    }, 5000);
                });

                // Add typing animation effect to logo text
                const logoTexts = document.querySelectorAll('.gradient-text');
                logoTexts.forEach(logoText => {
                    const originalText = logoText.textContent;
                    logoText.textContent = '';
                    
                    let i = 0;
                    function typeWriter() {
                        if (i < originalText.length) {
                            logoText.textContent += originalText.charAt(i);
                            i++;
                            setTimeout(typeWriter, 150);
                        }
                    }
                    
                    setTimeout(typeWriter, 1000);
                });
            });

            // Error handling
            window.addEventListener('error', function(e) {
                console.error('Error occurred:', e.error);
                showToast('Terjadi kesalahan. Silakan refresh halaman.', 'error');
            });

            // Offline detection
            window.addEventListener('offline', function() {
                showToast('Koneksi internet terputus', 'warning');
            });

            window.addEventListener('online', function() {
                showToast('Koneksi internet kembali', 'success');
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        </script>

        <!-- Additional scripts for specific pages -->
        @stack('scripts')
    </body>
</html>