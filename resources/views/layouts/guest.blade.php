<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>DEGODEGA</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
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
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
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

            .floating-particles {
                position: fixed;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: 0;
            }

            .particle {
                position: absolute;
                background: rgba(225, 213, 181, 0.1);
                border-radius: 50%;
                animation: float 6s infinite ease-in-out;
            }

            .particle:nth-child(1) { left: 20%; top: 30%; width: 8px; height: 8px; animation-delay: 0s; }
            .particle:nth-child(2) { left: 60%; top: 70%; width: 12px; height: 12px; animation-delay: 2s; }
            .particle:nth-child(3) { left: 40%; top: 20%; width: 6px; height: 6px; animation-delay: 4s; }

            .guest-container {
                background: rgba(21, 47, 48, 0.95);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(225, 213, 181, 0.2);
                border-radius: 24px;
                padding: 3rem;
                box-shadow: 
                    0 20px 40px rgba(0, 0, 0, 0.3),
                    0 0 0 1px rgba(225, 213, 181, 0.1);
                width: 100%;
                max-width: 28rem;
                position: relative;
                z-index: 2;
                animation: slideUp 0.8s ease-out;
            }

            .logo-container {
                text-align: center;
                margin-bottom: 2rem;
            }

            .logo-text {
                font-size: 2.5rem;
                font-weight: 700;
                background: linear-gradient(135deg, #e1d5b5, #d2c39a);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
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

            @media (max-width: 640px) {
                .guest-container {
                    padding: 2rem;
                    margin: 1rem;
                }
                
                .logo-text {
                    font-size: 2rem;
                }
            }
        </style>
    </head>
    <body>
        <!-- Floating Particles -->
        <div class="floating-particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>

        <div class="guest-container">
            <div class="logo-container">
                <div class="logo-text">DEGODEGA</div>
            </div>

            {{ $slot }}
        </div>

        <script>
            // Add typing animation effect to logo
            document.addEventListener('DOMContentLoaded', function() {
                const logoText = document.querySelector('.logo-text');
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
                
                setTimeout(typeWriter, 500);
            });
        </script>
    </body>
</html>