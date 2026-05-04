<!DOCTYPE html>
<html>
<head>
    <title>Products App</title>
</div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('products.index') }}">Product Manager</a>
    </div>
    <a href="/audit-logs" class="btn btn-light">Audit Logs</a>
</nav>

<div class="container mt-4">
    @yield('content')


</body>
</html>