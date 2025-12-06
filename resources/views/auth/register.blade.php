<!-- resources/views/auth/register.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register • MONETIX</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5530 100%);
            color: #e1d5b5;
            min-height: 100dvh;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* mulai dari atas biar gak kepotong di layar kecil */
            padding: 20px 20px 40px; /* tambah padding bawah biar aman */
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(circle at 15% 85%, rgba(22, 101, 52, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 85% 15%, rgba(5, 46, 22, 0.5) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(34, 85, 48, 0.25) 0%, transparent 50%);
            z-index: -1;
            animation: pulse 25s infinite alternate;
        }

        @keyframes pulse {
            0% { opacity: 0.75; }
            100% { opacity: 1; }
        }

        .particles {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            background: rgba(225, 213, 181, 0.18);
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(225, 213, 181, 0.4);
            animation: float 12s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.3; }
            50% { transform: translateY(-40px) rotate(180deg); opacity: 0.8; }
        }

        .container {
            background: rgba(21, 47, 48, 0.96);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(225, 213, 181, 0.25);
            padding: clamp(40px, 9vw, 65px) clamp(30px, 9vw, 48px);
            border-radius: clamp(24px, 5vw, 32px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6);
            width: 90%;
            max-width: 480px;
            text-align: center;
            position: relative;
            z-index: 2;
            margin-top: 5vh; /* jaga jarak dari atas di layar kecil */
        }

        .logo-text {
            font-size: clamp(2.5rem, 8vw, 3.4rem);
            font-weight: 700;
            background: linear-gradient(135deg, #e1d5b5, #f0e6d2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
            margin-bottom: clamp(25px, 6vw, 38px);
            letter-spacing: 1.5px;
        }

        h2 {
            font-size: clamp(1.7rem, 5vw, 2.1rem);
            font-weight: 600;
            margin-bottom: clamp(32px, 7vw, 48px);
            color: #e1d5b5;
        }

        .form-group {
            margin-bottom: clamp(20px, 5vw, 26px);
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: clamp(8px, 2vw, 12px);
            font-weight: 500;
            font-size: clamp(0.95rem, 3vw, 1.05rem);
            color: #e1d5b5;
        }

        .input-wrapper {
            position: relative;
        }

        input {
            width: 100%;
            padding: clamp(15px, 4vw, 18px) clamp(58px, 12vw, 68px) clamp(15px, 4vw, 18px) clamp(18px, 4vw, 22px);
            border-radius: clamp(14px, 3vw, 18px);
            border: 2px solid rgba(225, 213, 181, 0.35);
            background: rgba(25, 58, 60, 0.92);
            color: #e1d5b5;
            font-size: clamp(1rem, 3.5vw, 1.15rem);
            transition: all 0.4s ease;
        }

        input:focus {
            outline: none;
            border-color: #e1d5b5;
            box-shadow: 0 0 0 6px rgba(225, 213, 181, 0.25);
            transform: translateY(-3px);
        }

        .eye-toggle {
            position: absolute;
            right: clamp(14px, 3vw, 20px);
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            cursor: pointer;
            color: rgba(225, 213, 181, 0.85);
            padding: clamp(6px, 1.5vw, 8px);
            border-radius: 50%;
            transition: all 0.35s ease;
        }

        .eye-toggle:hover {
            color: #e1d5b5;
            background: rgba(225, 213, 181, 0.2);
            transform: translateY(-50%) scale(1.2);
        }

        .eye-toggle svg {
            width: clamp(22px, 5vw, 26px);
            height: clamp(22px, 5vw, 26px);
            stroke-width: 2.2;
        }

        .btn {
            padding: clamp(18px, 4vw, 22px);
            width: 100%;
            background: linear-gradient(135deg, #e1d5b5, #d2c39a);
            color: #0f2027;
            font-weight: 700;
            font-size: clamp(1.1rem, 4vw, 1.3rem);
            border: none;
            border-radius: clamp(14px, 3vw, 18px);
            cursor: pointer;
            transition: all 0.5s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 12px 35px rgba(225, 213, 181, 0.4);
        }

        .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 22px 50px rgba(225, 213, 181, 0.5);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: 0.8s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .footer {
            margin-top: clamp(28px, 6vw, 38px);
            font-size: clamp(0.95rem, 3vw, 1.05rem);
            color: rgba(225, 213, 181, 0.9);
        }

        .footer a {
            color: #e1d5b5;
            text-decoration: none;
            font-weight: 600;
            position: relative;
        }

        .footer a::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 2.5px;
            background: #e1d5b5;
            transition: width 0.5s ease;
        }

        .footer a:hover::after {
            width: 100%;
        }

        .error-message {
            color: #ff6b6b;
            font-size: clamp(0.9rem, 2.5vw, 0.95rem);
            text-align: left;
            margin-top: 8px;
            animation: shake 0.6s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        /* RESPONSIF EKSTREM — GAK ADA KEPOTONG */
        @media (max-height: 850px) {
            body {
                padding: 15px 20px 30px;
                align-items: flex-start;
            }
            .container {
                padding: clamp(35px, 8vw, 55px) clamp(25px, 8vw, 45px);
                margin-top: 2vh;
            }
            .logo-text {
                font-size: clamp(2.4rem, 7vw, 3.2rem);
                margin-bottom: clamp(20px, 5vw, 32px);
            }
            h2 {
                font-size: clamp(1.6rem, 4.5vw, 2rem);
                margin-bottom: clamp(25px, 6vw, 40px);
            }
            .form-group {
                margin-bottom: clamp(18px, 4vw, 24px);
            }
            input {
                padding: clamp(14px, 3.5vw, 17px) clamp(55px, 11vw, 65px) clamp(14px, 3.5vw, 17px) clamp(16px, 3.5vw, 20px);
                font-size: clamp(0.98rem, 3vw, 1.1rem);
            }
            .btn {
                padding: clamp(16px, 3.5vw, 20px);
                font-size: clamp(1.05rem, 3.5vw, 1.25rem);
            }
            .footer {
                margin-top: clamp(25px, 5vw, 35px);
            }
        }

        @media (max-height: 750px) {
            body {
                padding: 10px 20px 20px;
            }
            .container {
                padding: clamp(30px, 7vw, 50px) clamp(20px, 7vw, 40px);
            }
            .logo-text {
                font-size: clamp(2.2rem, 6.5vw, 3rem);
            }
            h2 {
                font-size: clamp(1.5rem, 4vw, 1.9rem);
            }
        }

        @media (max-height: 650px) {
            body {
                padding: 10px 20px;
            }
            .container {
                padding: 30px 20px;
            }
            .logo-text {
                font-size: 2.3rem;
                margin-bottom: 15px;
            }
            h2 {
                font-size: 1.6rem;
                margin-bottom: 20px;
            }
            .form-group {
                margin-bottom: 14px;
            }
            input {
                padding: 12px 55px 12px 16px;
                font-size: 0.95rem;
            }
            .btn {
                padding: 14px;
                font-size: 1.05rem;
            }
        }
    </style>
</head>
<body>
    <div class="particles"></div>

    <div class="container">
        <div class="logo">
            <div class="logo-text">MONETIX</div>
        </div>

        <h2>Create Account</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" required placeholder="••••••••">
                    <button type="button" class="eye-toggle" onclick="toggleEye(this)">
                        <svg viewBox="0 0 24 24" stroke="currentColor" fill="none">
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 616 0z" />
                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password_confirmation" required placeholder="••••••••">
                    <button type="button" class="eye-toggle" onclick="toggleEye(this)">
                        <svg viewBox="0 0 24 24" stroke="currentColor" fill="none">
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 616 0z" />
                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn">Create Account</button>
        </form>

        <div class="footer">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const logo = document.querySelector('.logo-text');
            const text = 'MONETIX';
            logo.textContent = '';
            let i = 0;
            setTimeout(() => {
                const type = () => {
                    if (i < text.length) {
                        logo.textContent += text[i];
                        i++;
                        setTimeout(type, 150);
                    }
                };
                type();
            }, 500);

            const particles = document.querySelector('.particles');
            for (let i = 0; i < 15; i++) {
                const p = document.createElement('div');
                p.className = 'particle';
                p.style.left = Math.random() * 100 + '%';
                p.style.top = Math.random() * 100 + '%';
                p.style.width = p.style.height = Math.random() * 16 + 8 + 'px';
                p.style.animationDelay = Math.random() * 10 + 's';
                p.style.opacity = Math.random() * 0.6 + 0.2;
                particles.appendChild(p);
            }

            document.querySelectorAll('input').forEach(input => {
                input.addEventListener('focus', () => input.closest('.form-group').style.transform = 'translateY(-4px)');
                input.addEventListener('blur', () => input.closest('.form-group').style.transform = 'translateY(0)');
            });
        });

        function toggleEye(btn) {
            const input = btn.parentElement.querySelector('input');
            const isPass = input.type === 'password';
            input.type = isPass ? 'text' : 'password';

            btn.innerHTML = isPass ? `
                <svg viewBox="0 0 24 24" stroke="currentColor" fill="none">
                    <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                </svg>
            ` : `
                <svg viewBox="0 0 24 24" stroke="currentColor" fill="none">
                    <path d="M15 12a3 3 0 11-6 0 3 3 0 616 0z"/>
                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            `;
        }
    </script>
</body>
</html>