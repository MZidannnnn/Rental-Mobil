<?php
// Menyertakan file untuk memeriksa login dan koneksi database
include '../controllers/prosesCekLogin.php';
include '../connection/koneksi.php'; // Pastikan file koneksi sesuai dengan pengaturan Anda
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mobil - Admin</title>

    <!-- Menyertakan file CSS Bootstrap 5 untuk styling halaman -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Ikon untuk tombol-tombol menggunakan Bootstrap Icons -->
    <link rel="stylesheet" href="../css/style.css"> <!-- Jika Anda memiliki style kustom, tambahkan file ini -->
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include '../components/sidebar.php'; ?>

        <!-- Konten Utama -->
        <div class="flex-grow-1">
            <!-- Top Bar -->
            <?php include '../components/topbar.php'; ?>

            <!-- Area Konten -->
            <div class="container mt-4">
                <h2 class="mb-4">Tambah Mobil</h2>
                <form action="../controllers/prosesTambahMobil.php" method="POST">
                    <!-- Form inputan mobil -->
                    <div class="mb-3">
                        <label for="merek" class="form-label">Merek Mobil</label>
                        <input type="text" class="form-control" id="merek" name="merek" required>
                    </div>
                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="model" name="model" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomorPolisi" class="form-label">Nomor Polisi</label>
                        <input type="text" class="form-control" id="nomorPolisi" name="nomorPolisi" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <!-- Mengganti input teks dengan dropdown -->
                        <select class="form-select" id="status" name="status" required>
                            <option value="" selected disabled>Pilih Status</option>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Disewa">Disewa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="hargaPerHari" class="form-label">Harga Per Hari</label>
                        <input type="number" class="form-control" id="hargaPerHari" name="hargaPerHari" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="tampilMobil.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Menyertakan Bootstrap 5 JS dan dependencies untuk komponen interaktif (seperti dropdowns, modals, dll.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
