<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>AbidjanSports Admin | Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(180deg, #00bcd4 0%, #03a9f4 30%, #29b6f6 60%, #4fc3f7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        /* Decorative shapes */
        body::before {
            content: '';
            position: absolute;
            top: 10%;
            left: 5%;
            width: 60px;
            height: 60px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
        }
        
        body::after {
            content: '';
            position: absolute;
            bottom: 15%;
            right: 10%;
            width: 0;
            height: 0;
            border-left: 30px solid transparent;
            border-right: 30px solid transparent;
            border-bottom: 50px solid rgba(255,255,255,0.2);
        }
        
        .decorative-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }
        
        .shape {
            position: absolute;
            opacity: 0.3;
        }
        
        .shape-1 {
            top: 20%;
            right: 15%;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.3);
            transform: rotate(45deg);
        }
        
        .shape-2 {
            bottom: 30%;
            left: 8%;
            width: 80px;
            height: 3px;
            background: rgba(255,255,255,0.4);
            transform: rotate(-30deg);
        }
        
        .shape-2::before,
        .shape-2::after {
            content: '';
            position: absolute;
            width: 80px;
            height: 3px;
            background: rgba(255,255,255,0.4);
        }
        
        .shape-2::before {
            top: 8px;
        }
        
        .shape-2::after {
            top: 16px;
        }
        
        .shape-3 {
            top: 60%;
            right: 5%;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
        }
        
        .welcome-text {
            position: absolute;
            top: 8%;
            left: 50%;
            transform: translateX(-50%);
            color: #1565c0;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        .login-container {
            position: relative;
            z-index: 10;
        }
        
        .illustration {
            display: flex;
            justify-content: center;
            margin-bottom: -40px;
            position: relative;
            z-index: 5;
        }
        
        .lock-icon {
            font-size: 100px;
            color: #ffc107;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));
        }
        
        .login-box {
            background: #3949ab;
            border-radius: 25px;
            padding: 60px 50px 40px;
            width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .login-title {
            color: #fff;
            text-align: center;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 20px;
        }
        
        .input-group .icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #3949ab;
            font-size: 1.1rem;
        }
        
        .input-group input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: box-shadow 0.3s;
        }
        
        .input-group input:focus {
            box-shadow: 0 0 0 3px rgba(255,193,7,0.5);
        }
        
        .input-group input::placeholder {
            color: #9e9e9e;
        }
        
        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 0.85rem;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            color: #fff;
            cursor: pointer;
        }
        
        .remember-me input {
            margin-right: 8px;
            accent-color: #ffc107;
        }
        
        .forgot-password {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .forgot-password:hover {
            color: #ffc107;
        }
        
        .btn-login {
            display: block;
            width: 140px;
            margin: 0 auto;
            padding: 12px;
            background: #fff;
            border: 2px solid #ffc107;
            border-radius: 25px;
            color: #3949ab;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-login:hover {
            background: #ffc107;
            color: #1a237e;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255,193,7,0.4);
        }
        
        .error-message {
            background: rgba(244,67,54,0.2);
            border: 1px solid #f44336;
            color: #fff;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
        }
        
        @media (max-width: 480px) {
            .login-box {
                width: 90%;
                padding: 50px 30px 30px;
            }
            
            .welcome-text {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="decorative-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    
    <h1 class="welcome-text">Bienvenue sur AbidjanSports</h1>
    
    <div class="login-container">
        <div class="illustration">
            <i class="bi bi-shield-lock-fill lock-icon"></i>
        </div>
        
        <div class="login-box">
            <h2 class="login-title">CONNEXION ADMIN</h2>
            
            <form action="{{ route('login') }}" method="post">
                @csrf
                
                @error('login')
                    <div class="error-message">
                        <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                    </div>
                @enderror
                
                <div class="input-group">
                    <i class="bi bi-person-fill icon"></i>
                    <input type="text" name="login" placeholder="Email ou nom d'utilisateur" value="{{ old('login') }}" required autofocus />
                </div>
                
                <div class="input-group">
                    <i class="bi bi-lock-fill icon"></i>
                    <input type="password" name="password" placeholder="Mot de passe" required />
                </div>
                
                <div class="options-row">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" />
                        Se souvenir de moi
                    </label>
                    <a href="#" class="forgot-password">Mot de passe oublié?</a>
                </div>
                
                <button type="submit" class="btn-login">Connexion</button>
            </form>
        </div>
    </div>
</body>
</html>
