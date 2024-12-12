<?php
include '../controllers/prosesCekLogin.php';
include '../connection/koneksi.php'; // Pastikan file koneksi sesuai
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Karyawan - Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php
        include '../components/sidebar.php';
        ?>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <!-- Top Bar -->
            <?php
            include '../components/topbar.php';
            ?>

            <!-- Content Area -->
            <div class="container mt-4">
                <h2 class="mb-4">Tambah Karyawan</h2>

                <!-- Form Tambah Karyawan -->
                <form action="../controllers/prosesTambahKaryawan.php" method="POST">
                    <div class="mb-3">
                        <label for="namaKaryawan" class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control" id="namaKaryawan" name="namaKaryawan" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="noTelp" class="form-label">No Telepon</label>
                        <input type="number" class="form-control" id="noTelp" name="noTelp" maxlength="13" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="tampilKaryawan.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
