<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Wedify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e91e63;
            --secondary-color: #f06292;
            --accent-color: #ad1457;
            --love-red: #d32f2f;
            --love-pink: #f8bbd9;
            --love-rose: #ffb3ba;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
            --bg-light: #fdf2f8;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--love-pink) 0%, var(--primary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .auth-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(233, 30, 99, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
            margin: 20px;
        }
        
        .auth-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        
        .auth-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .auth-header p {
            opacity: 0.9;
            font-size: 1rem;
        }
        
        .auth-body {
            padding: 40px 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            color: var(--text-dark);
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control {
            border: 2px solid #e0e0e0 !important;
            border-top: 2px solid #e0e0e0 !important;
            border-right: 2px solid #e0e0e0 !important;
            border-bottom: 2px solid #e0e0e0 !important;
            border-left: 2px solid #e0e0e0 !important;
            border-radius: 12px !important;
            padding: 12px 20px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #fafafa;
            box-sizing: border-box;
        }
        
        .form-control:focus {
            border: 2px solid var(--primary-color) !important;
            border-top: 2px solid var(--primary-color) !important;
            border-right: 2px solid var(--primary-color) !important;
            border-bottom: 2px solid var(--primary-color) !important;
            border-left: 2px solid var(--primary-color) !important;
            box-shadow: 0 0 0 3px rgba(233, 30, 99, 0.1);
            background: white;
            outline: none;
        }.input-group {
            position: relative;
        }
        
        .input-group .form-control {
            padding-left: 50px;
        }
        
        .input-group-text {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-light);
            z-index: 10;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(233, 30, 99, 0.3);
        }
        
        .form-check {
            margin: 20px 0;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .auth-links {
            margin-top: 25px;
        }
        
        .auth-links .link-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .auth-links a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .auth-links a:hover {
            color: var(--accent-color);
        }
        
        .alert {
            border-radius: 12px;
            margin-bottom: 20px;
        }
        
        .back-to-home {
            position: absolute;
            top: 20px;
            left: 20px;
            color: white;
            font-size: 1.2rem;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.2);
            padding: 12px;
            border-radius: 50% !important;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .back-to-home:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }
        
        @media (max-width: 576px) {
            .auth-container {
                margin: 10px;
            }
            
            .auth-header {
                padding: 30px 20px;
            }
            
            .auth-header h1 {
                font-size: 2rem;
            }
            
            .auth-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <a href="{{ url('/') }}" class="back-to-home">
        <i class="fas fa-arrow-left"></i>
    </a>
    
    <div class="auth-container">
        <div class="auth-header">
            <h1><i class="fas fa-heart"></i> Wedify</h1>
            <p>Welcome back to your dream wedding planner</p>
        </div>
        
        <div class="auth-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
            </form>
            
            <div class="auth-links">
                <div class="link-container">
                    <span>Don't have an account?</span>
                    <a href="{{ route('register') }}">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>