<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Financial Dashboard</title>
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
            color: #e1d5b5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
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
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
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

        .auth-container {
            background: rgba(21, 47, 48, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(225, 213, 181, 0.2);
            padding: 50px 40px;
            border-radius: 24px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(225, 213, 181, 0.1);
            width: 90%;
            max-width: 500px;
            text-align: center;
            position: relative;
            z-index: 2;
            animation: slideUp 0.8s ease-out;
        }

        .logo {
            margin-bottom: 30px;
            animation: fadeIn 1s ease-out;
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

        .auth-container h2 {
            margin-bottom: 30px;
            font-size: 2rem;
            color: #e1d5b5;
            font-weight: 600;
            animation: fadeIn 1s ease-out 0.2s both;
        }

        .form-group {
            margin-bottom: 20px;
            animation: fadeIn 1s ease-out 0.4s both;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            text-align: left;
            color: #e1d5b5;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 16px;
            border-radius: 12px;
            border: 2px solid rgba(225, 213, 181, 0.3);
            background: rgba(25, 58, 60, 0.8);
            color: #e1d5b5;
            font-size: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-group input:focus {
            outline: none;
            border-color: #e1d5b5;
            box-shadow: 0 0 0 3px rgba(225, 213, 181, 0.1);
            transform: translateY(-2px);
        }

        .form-group input::placeholder {
            color: rgba(225, 213, 181, 0.6);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            animation: fadeIn 1s ease-out 0.5s both;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input {
            width: 16px;
            height: 16px;
            accent-color: #e1d5b5;
        }

        .remember-me label {
            margin: 0;
            color: rgba(225, 213, 181, 0.8);
            font-size: 0.9rem;
        }

        .forgot-password {
            color: #e1d5b5;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: #d2c39a;
            text-decoration: underline;
        }

        .error-message {
            color: #ff6b6b;
            margin-top: 8px;
            font-size: 0.9rem;
            text-align: left;
            animation: shake 0.5s ease-in-out;
        }

        .auth-btn {
            margin-top: 30px;
            padding: 16px;
            width: 100%;
            background: linear-gradient(135deg, #e1d5b5, #d2c39a);
            color: #193a3c;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
            animation: fadeIn 1s ease-out 0.6s both;
        }

        .auth-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .auth-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(225, 213, 181, 0.3);
        }

        .auth-btn:hover::before {
            left: 100%;
        }

        .auth-btn:active {
            transform: translateY(-1px);
        }

        .footer-text {
            margin-top: 25px;
            color: rgba(225, 213, 181, 0.8);
            font-size: 0.95rem;
            animation: fadeIn 1s ease-out 0.8s both;
        }

        .footer-text a {
            color: #e1d5b5;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .footer-text a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #e1d5b5;
            transition: width 0.3s ease;
        }

        .footer-text a:hover::after {
            width: 100%;
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

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @media (max-width: 768px) {
            .auth-container {
                padding: 40px 30px;
                margin: 20px;
            }
            
            .logo-text {
                font-size: 2rem;
            }
            
            .auth-container h2 {
                font-size: 1.8rem;
            }
            
            .remember-forgot {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="floating-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="auth-container">
        <div class="logo">
            <div class="logo-text">DEGODEGA</div>
        </div>

        <h2>Welcome Back</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-forgot">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="auth-btn">
                Login
            </button>
        </form>
        
        <div class="footer-text">
            Don't have an account? <a href="{{ route('register') }}">Sign up here</a>
        </div>
    </div>

    <script>
        // Add interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    input.parentElement.style.transform = 'translateY(-2px)';
                });
                
                input.addEventListener('blur', () => {
                    input.parentElement.style.transform = 'translateY(0)';
                });
            });

            // Add typing animation effect
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