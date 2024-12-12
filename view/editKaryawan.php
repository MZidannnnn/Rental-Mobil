<?php
include '../controllers/prosesCekLogin.php';
include '../connection/koneksi.php';

// Ambil ID karyawan dari URL
$idKaryawan = $_GET['id'];

// Query untuk mendapatkan data karyawan berdasarkan ID
$query = "SELECT * FROM karyawan WHERE idKaryawan = '$idKaryawan'";
$result = mysqli_query($db, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>
            alert('Data karyawan tidak ditemukan!');
            window.location.href = 'tampilKaryawan.php';
          </script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ediy Karyawan - Rental Mobil</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Menyertakan Bootstrap Icons -->
    <!-- Custom CSS (optional for customizations) -->
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
            <h2>Edit Data Karyawan</h2>
        <form action="../controllers/prosesEditKaryawan.php" method="POST">
            <input type="hidden" name="idKaryawan" value="<?= $data['idKaryawan'] ?>">

            <div class="mb-3">
                <label for="namaKaryawan" class="form-label">Nama Karyawan</label>
                <input type="text" class="form-control" id="namaKaryawan" name="namaKaryawan" value="<?= $data['namaKaryawan'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $data['username'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin diubah)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="mb-3">
                <label for="noTelp" class="form-label">No Telepon</label>
                <input type="text" class="form-control" id="noTelp" name="noTelp" value="<?= $data['noTelp'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= $data['alamat'] ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="tampilKaryawan.php" class="btn btn-secondary">Kembali</a>
        </form>

            </div>
        </div>

    </div>

    </div>

    <!-- Bootstrap 5 JS, Popper.js, dan Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>