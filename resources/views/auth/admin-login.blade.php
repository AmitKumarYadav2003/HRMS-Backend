<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - HRMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2E86DE 0%, #1B4F72 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .login-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 420px;
            padding: 40px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h1 {
            font-size: 28px;
            font-weight: 800;
            color: #1A1D29;
            margin-bottom: 8px;
        }
        .login-header p {
            color: #6B7280;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 600;
            color: #1A1D29;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .form-control {
            border: 1.5px solid #E5E7EB;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #2E86DE;
            box-shadow: 0 0 0 3px rgba(46, 134, 222, 0.1);
        }
        .btn-login {
            background: #2E86DE;
            border: none;
            color: white;
            font-weight: 700;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: #1B4F72;
            color: white;
        }
        .btn-login:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
            border: none;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .checkbox-group input {
            margin-right: 8px;
        }
        .checkbox-group label {
            margin: 0;
            font-size: 13px;
            color: #6B7280;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>🔐 Admin Portal</h1>
            <p>HRMS Management System</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Login Failed!</strong>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input 
                    type="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    placeholder="admin@hrms.com"
                    required
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    id="password" 
                    name="password" 
                    placeholder="••••••••"
                    required
                >
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="remember" name="remember" value="1">
                <label for="remember">Remember me for 30 days</label>
            </div>

            <button type="submit" class="btn btn-login">Sign In</button>
        </form>

        <div style="text-align: center; margin-top: 20px; font-size: 13px; color: #6B7280;">
            <p>Only authorized administrators can access this portal.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>