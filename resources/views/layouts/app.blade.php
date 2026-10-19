<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Campushub</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar Utama -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3 shadow-sm">
    <a class="navbar-brand fw-bold" href="/">Campushub</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active fw-bold' : '' }}" href="/">FYP (Random)</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('kota*') ? 'active fw-bold' : '' }}" href="/kota">Forum Kota</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('kampus*') ? 'active fw-bold' : '' }}" href="/kampus">Forum Kampus</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->is('tentang*') ? 'active fw-bold' : '' }}" href="/tentang">Tentang</a></li>
        </ul>
    </div>
</nav>

<!-- Konten Utama -->
<div class="container mt-4 mb-5">
    @yield('content')
</div>

<!-- Footer -->
<footer class="py-3 bg-white text-center border-top mt-auto">
    <div class="container text-muted small">&copy; {{ date('Y') }} Campushub. Platform Komunitas Mahasiswa.</div>
</footer>

</body>
</html>