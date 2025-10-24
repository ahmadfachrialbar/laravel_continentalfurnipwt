@vite(['resources/css/app.css', 'resources/js/app.js'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel + Bootstrap Test</title>
</head>
<body>

    <div class="container mt-5">
        <!-- Judul -->
        <h1 class="text-center text-primary">🚀 Laravel + Bootstrap Berhasil!</h1>
        <p class="text-muted text-center">Ini halaman test menggunakan Bootstrap 5</p>

        <!-- Alert -->
        <div class="alert alert-success mt-4" role="alert">
            Bootstrap sudah jalan dengan baik! 🎉
        </div>

        <!-- Button -->
        <div class="text-center">
            <button class="btn btn-primary">Tombol Biru</button>
            <button class="btn btn-danger">Tombol Merah</button>
        </div>

        <!-- Card -->
        <div class="card mt-5 shadow">
            <div class="card-header bg-dark text-white">
                Contoh Card
            </div>
            <div class="card-body">
                <h5 class="card-title">Halo Laravel</h5>
                <p class="card-text">Ini adalah contoh komponen card Bootstrap di Laravel.</p>
                <a href="#" class="btn btn-success">Lihat Detail</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
