<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<main class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <form class="p-4 bg-white shadow rounded" style="width: 400px;" action="{{ route('user.doRegister') }}" method="post" id="register-form">
        @csrf
        
        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter name" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter email" value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Repeat Password -->
        <div class="mb-3">
            <label for="repeat_password" class="form-label">Repeat Password:</label>
            <input type="password" class="form-control @error('password_repeat') is-invalid @enderror" name="password_repeat" placeholder="Repeat password">
            @error('password_repeat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
    </form>
</main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>