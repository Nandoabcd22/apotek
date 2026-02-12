<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Apotek Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
        }

        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 500px;
            animation: slideInUp 0.5s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            text-align: center;
            padding: 30px 20px;
            border: none;
        }

        .card-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 5px;
        }

        .card-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 14px;
        }

        .card-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .btn-register {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(37, 99, 235, 0.4);
            color: white;
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
        }

        .login-link p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: var(--secondary-color);
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 16px;
        }

        .input-icon .form-control {
            padding-left: 45px;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
            border: none;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-section i {
            font-size: 40px;
            color: white;
            margin-bottom: 10px;
        }

        .password-requirements {
            font-size: 12px;
            color: #666;
            margin-top: 8px;
        }

        .password-requirements ul {
            margin: 5px 0 0 0;
            padding-left: 20px;
        }

        .password-requirements li {
            margin: 3px 0;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="card">
            <div class="card-header">
                <div class="logo-section">
                    <i class="bi bi-hospital"></i>
                </div>
                <h2>Apotek</h2>
                <p>Daftar Akun Baru</p>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i> <strong>Registrasi Gagal!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <div class="input-icon">
                            <i class="bi bi-person"></i>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="Masukkan nama lengkap Anda" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-icon">
                            <i class="bi bi-envelope"></i>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Masukkan email Anda" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-icon">
                            <i class="bi bi-lock"></i>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" 
                                   placeholder="Minimal 6 karakter" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="password-requirements">
                            <strong>Persyaratan password:</strong>
                            <ul>
                                <li>Minimal 6 karakter</li>
                                <li>Gunakan kombinasi angka dan huruf</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <div class="input-icon">
                            <i class="bi bi-lock-check"></i>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" name="password_confirmation" 
                                   placeholder="Ulangi password Anda" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="agree" required>
                        <label class="form-check-label" for="agree">
                            Saya setuju dengan <a href="#" style="color: var(--primary-color); text-decoration: none;">Syarat & Ketentuan</a>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-register">
                        <i class="bi bi-person-plus"></i> Daftar Akun
                    </button>
                </form>

                <div class="login-link">
                    <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
