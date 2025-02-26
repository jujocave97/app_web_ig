<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <form class="p-4 bg-white shadow rounded {{ $errors->any() ? 'border border-danger' : '' }}" style="width: 400px;" action="{{ route('user.doLogin') }}" method="post">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="input_email" name="email" placeholder="Enter email" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="input_password" name="password" placeholder="Password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @error('credentials')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botones de Submit y Registro -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary w-48">Iniciar Sesión</button>

                <a href="{{ route('user.showRegister') }}" class="btn btn-secondary w-48">Registrarse</a>
            </div>
        </form>
    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
