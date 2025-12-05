<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DADF</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Instrument Sans', sans-serif;
                background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5530 100%);
                color: #f8f9fa;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 2rem;
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
                z-index: -1;
            }

            .container {
                max-width: 1200px;
                width: 100%;
                position: relative;
                z-index: 1;
            }

            header {
                width: 100%;
                margin-bottom: 3rem;
                text-align: right;
            }

            nav {
                display: flex;
                gap: 1rem;
                justify-content: flex-end;
                align-items: center;
            }

            .nav-link {
                display: inline-block;
                padding: 0.75rem 1.5rem;
                background: rgba(22, 101, 52, 0.2);
                border: 1px solid rgba(34, 197, 94, 0.3);
                border-radius: 8px;
                color: #d1fae5;
                text-decoration: none;
                font-size: 0.875rem;
                font-weight: 500;
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
            }
            

            .no-drag{     
                user-select: none;
                -webkit-user-drag: none;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                pointer-events: auto;
            }


            .nav-link:hover {
                background: rgba(22, 101, 52, 0.4);
                border-color: rgba(34, 197, 94, 0.6);
                color: #fff;
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(22, 101, 52, 0.3);
            }

            .main-content {
                display: flex;
                gap: 0;
                width: 100%;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
                backdrop-filter: blur(20px);
                animation: fadeInUp 0.8s ease-out;
            }

            .content-section {
                flex: 1;
                padding: 3rem;
                background: rgba(22, 101, 52, 0.1);
                border: 1px solid rgba(34, 197, 94, 0.2);
                backdrop-filter: blur(15px);
            }

            .logo-section {
                flex: 1;
                background: linear-gradient(135deg, rgba(5, 46, 22, 0.8) 0%, rgba(22, 101, 52, 0.6) 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(34, 197, 94, 0.3);
            }

            .logo-section::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: conic-gradient(from 0deg, transparent, rgba(34, 197, 94, 0.1), transparent);
                animation: rotate 20s linear infinite;
            }

            h1 {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
                color: #ecfdf5;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            }

            .subtitle {
                font-size: 0.875rem;
                color: #a7f3d0;
                margin-bottom: 2rem;
                line-height: 1.6;
            }

            .feature-list {
                list-style: none;
                margin-bottom: 2rem;
            }

            .feature-item {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1rem 0;
                position: relative;
            }

            .feature-item:not(:last-child)::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 2rem;
                right: 0;
                height: 1px;
                background: linear-gradient(to right, rgba(34, 197, 94, 0.2), transparent);
            }

            .feature-icon {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: linear-gradient(135deg, #059669, #34d399);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
            }

            .feature-icon::before {
                content: '';
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: #ecfdf5;
            }

            .feature-text {
                color: #d1fae5;
                font-size: 0.875rem;
            }

            .feature-link {
                color: #34d399;
                text-decoration: none;
                font-weight: 600;
                margin-left: 0.5rem;
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .feature-link:hover {
                color: #6ee7b7;
                text-shadow: 0 0 8px rgba(52, 211, 153, 0.5);
            }

            .external-icon {
                display: inline-block;
                width: 12px;
                height: 12px;
                margin-left: 0.25rem;
                opacity: 0.8;
            }

            .cta-section {
                display: flex;
                gap: 1rem;
                margin-top: 1rem;
            }

            .btn-primary {
                display: inline-block;
                padding: 1rem 2rem;
                background: linear-gradient(135deg, #059669, #34d399);
                border: none;
                border-radius: 8px;
                color: #065f46;
                text-decoration: none;
                font-weight: 600;
                font-size: 0.875rem;
                transition: all 0.3s ease;
                cursor: pointer;
                box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
                background: linear-gradient(135deg, #047857, #10b981);
            }

            .laravel-logo {
                font-size: 4rem;
                font-weight: 700;
                color: #34d399;
                text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                letter-spacing: -0.05em;
                position: relative;
                z-index: 2;
            }

            /* Popup Styles */
            .popup-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.8);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                backdrop-filter: blur(10px);
            }

            .popup-overlay.show {
                opacity: 1;
                visibility: visible;
            }

            .popup-content {
                position: relative;
                max-width: 90vw;
                max-height: 90vh;
                background: rgba(22, 101, 52, 0.1);
                border: 2px solid rgba(34, 197, 94, 0.3);
                border-radius: 16px;
                padding: 2rem;
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
                transform: scale(0.8) translateY(30px);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                backdrop-filter: blur(20px);
            }

            .popup-overlay.show .popup-content {
                transform: scale(1) translateY(0);
            }

            .popup-close {
                position: absolute;
                top: 1rem;
                right: 1rem;
                width: 20px;
                height: 20px;
                border: none;
                background: rgba(239, 68, 68, 0.2);
                border: 1px solid rgba(239, 68, 68, 0.3);
                border-radius: 50%;
                color: #fecaca;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                transition: all 0.3s ease;
                z-index: 10;
            }

            .popup-close:hover {
                background: rgba(239, 68, 68, 0.4);
                border-color: rgba(239, 68, 68, 0.6);
                transform: scale(1.1);
            }

            .popup-image {
                max-width: 100%;
                height: auto;
                max-height: 60vh;   /* <<< tambahkan ini */
                object-fit: contain;/* <<< dan ini */
                border-radius: 12px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
                display: block;
                margin: 0 auto;
            }


            .popup-title {
                text-align: center;
                margin-bottom: 1.5rem;
                color: #34d399;
                font-size: 1.5rem;
                font-weight: 600;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            }

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

            @keyframes rotate {
                from {
                    transform: rotate(0deg);
                }
                to {
                    transform: rotate(360deg);
                }
            }

            @keyframes popupBounce {
                0% {
                    transform: scale(0.3) rotate(-10deg);
                    opacity: 0;
                }
                50% {
                    transform: scale(1.05) rotate(2deg);
                }
                70% {
                    transform: scale(0.95) rotate(-1deg);
                }
                100% {
                    transform: scale(1) rotate(0deg);
                    opacity: 1;
                }
            }

            @media (max-width: 768px) {
                .main-content {
                    flex-direction: column-reverse;
                }

                .content-section,
                .logo-section {
                    padding: 2rem;
                }

                .laravel-logo {
                    font-size: 3rem;
                }

                header {
                    margin-bottom: 2rem;
                }

                nav {
                    justify-content: center;
                    flex-wrap: wrap;
                }

                .popup-content {
                    padding: 1rem;
                    margin: 1rem;
                }

                .popup-title {
                    font-size: 1.25rem;
                }
            }

            .logo-pattern {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image: 
                    radial-gradient(circle at 25% 25%, rgba(34, 197, 94, 0.1) 2px, transparent 2px),
                    radial-gradient(circle at 75% 75%, rgba(34, 197, 94, 0.05) 1px, transparent 1px);
                background-size: 40px 40px, 20px 20px;
                opacity: 0.3;
            }

            .content-decoration {
                position: absolute;
                top: 1rem;
                right: 1rem;
                width: 100px;
                height: 100px;
                background: radial-gradient(circle, rgba(34, 197, 94, 0.1) 0%, transparent 70%);
                border-radius: 50%;
                pointer-events: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <header>
                @if (Route::has('login'))
                    <nav>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="nav-link">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="nav-link">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="nav-link">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <main class="main-content">
                <section class="content-section">
                    <div class="content-decoration"></div>
                    <h1>MANTAP PAK WEBNYA</h1>
                    <p class="subtitle">BUATAN KELOMPOK *DADF*<br>DIGO ABIGEL DANIEL FEYZA.</p>
                    
                    <ul class="feature-list">
                        <li class="feature-item">
                            <div class="feature-icon"></div>
                            <span class="feature-text">
                                CREDIT!
                                <a href="#" onclick="openPopup()" class="feature-link">
                                    DADF
                                    <svg class="external-icon" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square"/>
                                    </svg>  
                                </a>
                            </span>
                        </li>
                        <li class="feature-item">
                            <div class="feature-icon"></div>
                            <span class="feature-text">
                                TANYA TANYA DI SINI WOI
                                <a href="https://wa.me/6285386605967" target="_blank" class="feature-link">
                                    WA DEGO
                                    <svg class="external-icon" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square"/>
                                    </svg>
                                </a>
                            </span>
                        </li>
                    </ul>

                    <div class="cta-section">
                        <a href="https://smaridasa.com" target="_blank" class="btn-primary">
                            SEKOLAH TERBAEK
                        </a>
                    </div>
                </section>

                <section class="logo-section">
                    <div class="logo-pattern"></div>
                    <div class="laravel-logo">DEGODEGA</div>
                </section>
            </main>
        </div>

        <!-- Popup Modal -->
        <div id="creditPopup" class="popup-overlay" onclick="closePopup(event)">
            <div class="popup-content" onclick="event.stopPropagation()">
                <button class="popup-close" onclick="closePopup()">&times;</button>
                <h2 class="popup-title">CREDIT TEAM DADF</h2>
                <img src="images/creditkami.png" alt="Credit DADF" class="popup-image no-drag" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" oncontextmenu="return false;"draggable="false">
                <div style="display: none; text-align: center; padding: 2rem; color: #a7f3d0;">
                    <p>Gambar tidak ditemukan</p>
                    <p style="font-size: 0.875rem; margin-top: 0.5rem;">Pastikan file gambar berada di folder <strong>public/images/creditkami.jpg</strong></p>
                </div>
            </div>
        </div>

        <script>
            function openPopup() {
                const popup = document.getElementById('creditPopup');
                popup.classList.add('show');
                document.body.style.overflow = 'hidden'; // Mencegah scroll pada background
            }

            function closePopup(event) {
                // Jika event ada dan target adalah popup content, jangan tutup
                if (event && event.target.closest('.popup-content') && event.target !== event.currentTarget) {
                    return;
                }
                
                const popup = document.getElementById('creditPopup');
                popup.classList.remove('show');
                document.body.style.overflow = 'auto'; // Kembalikan scroll
            }

            // Tutup popup dengan tombol ESC
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closePopup();
                }
            });

            // Tambahkan efek smooth loading untuk gambar
            document.querySelector('.popup-image').addEventListener('load', function() {
                this.style.animation = 'popupBounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
            });


            // Mencegah klik kanan pada gambar popup
            document.addEventListener("DOMContentLoaded", () => {
                const img = document.querySelector(".popup-image");
                if (img) {
                    img.addEventListener("contextmenu", e => e.preventDefault());
                }
            });
        </script>
    </body>
</html>