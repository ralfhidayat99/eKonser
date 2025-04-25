<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5 col-md-6">
        <div class="card p-5">
            <h1 class="mb-4">Register</h1>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
                    </div>
                    @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    @error('password_confirmation')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            <p class="mt-3">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  
</body>

</html>
