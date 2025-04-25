<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'eKonser')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main.container {
            flex: 1 0 auto;
        }
        footer {
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    <header class="bg-dark text-white p-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0"><a href="/" class="text-white text-decoration-none">eKonser</a></h1>
            <div>
                @auth
                    <span class="me-3">Welcome, {{ Auth::user()->name }}</span>
                    <a href="{{ url('tickets/my') }}" class="btn btn-outline-light btn-sm me-2" title="My Tickets"><i class="bi bi-cart"></i></a> |
                  
                    <form method="POST" action="{{ route('logout') }}" class="d-inline ms-2">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm ms-2">Register</a>
                @endauth
            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    @yield('scripts')
</body>
</html>
