<?php
// Menyertakan file untuk memeriksa login dan koneksi database
include '../controllers/prosesCekLogin.php'; // Cek login user sebelum akses halaman
include '../connection/koneksi.php'; // Menghubungkan ke database menggunakan koneksi yang sudah didefinisikan
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata untuk halaman HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan - Admin</title>

    <!-- Menyertakan file CSS Bootstrap 5 untuk styling halaman -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Ikon untuk tombol-tombol menggunakan Bootstrap Icons -->
    <link rel="stylesheet" href="../css/style.css"> <!-- Menyertakan style CSS kustom jika ada -->
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar, memuat navigasi samping -->
        <?php include '../components/sidebar.php'; ?>

        <!-- Konten Utama, konten yang tampil di halaman utama setelah sidebar -->
        <div class="flex-grow-1">
            <!-- Top Bar, bagian atas halaman yang berisi header -->
            <?php include '../components/topbar.php'; ?>

            <!-- Area Konten, tempat form dan data tampil -->
            <div class="container mt-4">
                <h2 class="mb-4">Tambah Pelanggan</h2>
                
                <!-- Form untuk menambah pelanggan -->
                <form action="../controllers/prosesTambahPelanggan.php" method="POST">
                    <!-- Form inputan nama pelanggan -->
                    <div class="mb-3">
                        <label for="namaPelanggan" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="namaPelanggan" name="namaPelanggan" required>
                        <!-- input untuk nama pelanggan, wajib diisi -->
                    </div>

                    <!-- Form inputan alamat pelanggan -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                        <!-- textarea untuk alamat, untuk teks panjang -->
                    </div>

                    <!-- Form inputan nomor telepon pelanggan -->
                    <div class="mb-3">
                        <label for="noTelp" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="noTelp" name="noTelp" maxlength="13" required>
                        <!-- input untuk nomor telepon, dibatasi panjangnya 13 karakter sesuai kolom -->
                    </div>

                    <!-- Tombol Simpan untuk menyimpan data pelanggan -->
                    <button type="submit" class="btn btn-primary">Simpan</button>

                    <!-- Tombol Kembali untuk kembali ke halaman daftar pelanggan -->
                    <a href="tampilPelanggan.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Menyertakan Bootstrap 5 JS dan dependencies untuk komponen interaktif (seperti dropdowns, modals, dll.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
