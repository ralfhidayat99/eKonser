<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'eKonser')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-dark text-white p-3 mb-4">
        <div class="container">
            <h1 class="h3">eKonser</h1>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer class="bg-light text-center text-muted py-3 mt-4">
        <div class="container">
            &copy; {{ date('Y') }} eKonser. All rights reserved.
        </div>
    </footer>
</body>
</html>
