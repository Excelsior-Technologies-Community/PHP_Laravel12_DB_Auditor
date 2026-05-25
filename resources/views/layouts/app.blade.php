<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Manager</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg: #f5f6fa;
            --card: #ffffff;
            --text: #111;
            --nav: #111827;
        }

        body.dark {
            --bg: #0f172a;
            --card: #1e293b;
            --text: #e5e7eb;
            --nav: #020617;
        }

        body {
            background: var(--bg);
            color: var(--text);
            transition: 0.3s;
        }

        .navbar {
            background: var(--nav) !important;
        }

        .card {
            background: var(--card);
            color: var(--text);
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .btn {
            border-radius: 10px;
        }

        .table {
            color: var(--text);
        }

        .toggle-btn {
            cursor: pointer;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark px-3">

    <a class="navbar-brand fw-bold" href="{{ route('products.index') }}">
        🛒 Product Manager
    </a>

    <div class="d-flex gap-2 align-items-center">

        <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-sm">
            Products
        </a>

        <a href="/audit-logs" class="btn btn-warning btn-sm">
            Audit Logs
        </a>

        <!-- DARK MODE TOGGLE -->
        <button class="btn btn-light btn-sm toggle-btn" onclick="toggleDark()">
            🌙
        </button>

    </div>

</nav>

<!-- SUCCESS MESSAGE -->
<div class="container mt-3">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

</div>

<!-- MAIN CONTENT -->
<div class="container mt-4 mb-5">
    <div class="card p-4">
        @yield('content')
    </div>
</div>

<!-- FOOTER -->
<footer class="text-center py-3">
    <small>Laravel Product Manager © {{ date('Y') }}</small>
</footer>

<!-- DARK MODE SCRIPT -->
<script>
    function toggleDark() {
        document.body.classList.toggle('dark');

        // save mode
        if(document.body.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    }

    // load mode
    window.onload = function () {
        if(localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark');
        }
    }
</script>

</body>
</html>