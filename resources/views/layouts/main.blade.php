<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIRRPASNA</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">SIRRPASNA</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/kriteria">Kriteria</a></li>
                    <li class="nav-item"><a class="nav-link" href="/alternatif">Data Kerusakan</a></li>
                    <li class="nav-item"><a href="{{ route('proyek.index') }}"
                        class="nav-link {{ request()->routeIs('proyek.*') ? 'active' : '' }}">
                            <i class="bi bi-folder-check"></i><span>Manajemen Proyek</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="/nilai-kriteria">Nilai Kriteria</a></li>
                    <li class="nav-item">
                        <a href="{{ route('prioritas.index') }}"
                        class="nav-link {{ request()->routeIs('prioritas.*') ? 'active' : '' }}">
                            <i class="bi bi-bar-chart-line"></i>
                            <span>Daftar Prioritas Proyek</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Halaman -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
