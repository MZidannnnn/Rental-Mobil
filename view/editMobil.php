<?php
// Menyertakan file untuk memeriksa apakah pengguna sudah login
include '../controllers/prosesCekLogin.php';

// Menyertakan file koneksi database
include '../connection/koneksi.php';

// Mengambil ID mobil dari URL menggunakan metode GET
$idMobil = $_GET['id'];

// Membuat query SQL untuk mengambil data mobil berdasarkan ID
$query = "SELECT * FROM mobil WHERE idMobil = '$idMobil'";
$result = mysqli_query($db, $query); // Menjalankan query ke database

// Mengambil hasil query sebagai array asosiatif
$data = mysqli_fetch_assoc($result);

// Validasi jika data tidak ditemukan (misalnya ID tidak valid atau tidak ada di database)
if (!$data) {
    // Jika data tidak ditemukan, tampilkan pesan peringatan dan alihkan ke halaman daftar mobil
    echo "<script>
            alert('Data mobil tidak ditemukan!');
            window.location.href = 'tampilMobil.php';
          </script>";
    exit; // Menghentikan eksekusi script
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata dasar untuk pengaturan halaman -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mobil - Rental Mobil</title>

    <!-- Bootstrap CSS untuk styling dan tampilan responsif -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons untuk ikon tambahan -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Menyertakan file CSS custom (opsional untuk styling tambahan) -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar untuk navigasi utama -->
        <?php
        // Menyertakan komponen sidebar dari file terpisah
        include '../components/sidebar.php';
        ?>

        <!-- Area Konten Utama -->
        <div class="flex-grow-1">
            <!-- Topbar untuk header halaman -->
            <?php
            // Menyertakan komponen topbar dari file terpisah
            include '../components/topbar.php';
            ?>

            <!-- Area untuk form edit mobil -->
            <div class="container mt-4">
                <h2>Edit Data Mobil</h2> <!-- Judul halaman -->

                <!-- Form untuk mengedit data mobil -->
                <form action="../controllers/prosesEditMobil.php" method="POST">
                    <!-- Field tersembunyi untuk menyimpan ID mobil -->
                    <input type="hidden" name="idMobil" value="<?= $data['idMobil'] ?>">

                    <!-- Input untuk Merek Mobil -->
                    <div class="mb-3">
                        <label for="merek" class="form-label">Merek</label>
                        <input
                            type="text"
                            class="form-control"
                            id="merek"
                            name="merek"
                            value="<?= $data['merek'] ?>"
                            required>
                        <!-- Value default diambil dari database -->
                    </div>

                    <!-- Input untuk Model Mobil -->
                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input
                            type="text"
                            class="form-control"
                            id="model"
                            name="model"
                            value="<?= $data['model'] ?>"
                            required>
                        <!-- Value default diambil dari database -->
                    </div>

                    <!-- Input untuk Tahun Pembuatan Mobil -->
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input
                            type="number"
                            class="form-control"
                            id="tahun"
                            name="tahun"
                            value="<?= $data['tahun'] ?>"
                            required>
                        <!-- Menggunakan type "number" untuk validasi angka -->
                    </div>

                    <!-- Input untuk Nomor Polisi -->
                    <div class="mb-3">
                        <label for="nomorPolisi" class="form-label">Nomor Polisi</label>
                        <input
                            type="text"
                            class="form-control"
                            id="nomorPolisi"
                            name="nomorPolisi"
                            value="<?= $data['nomorPolisi'] ?>"
                            required>
                        <!-- Value default diambil dari database -->
                    </div>

                    <!-- Dropdown untuk memilih Status Mobil -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select
                            class="form-select"
                            id="status"
                            name="status"
                            required>
                            <!-- Pilihan tersedia -->
                            <option value="Tersedia" <?= $data['status'] == 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
                            <option value="Disewa" <?= $data['status'] == 'Disewa' ? 'selected' : '' ?>>Disewa</option>
                        </select>
                        <!-- Pilihan yang sesuai dengan data di database akan otomatis dipilih -->
                    </div>

                    <!-- Input untuk Harga Sewa Per Hari -->
                    <div class="mb-3">
                        <label for="hargaPerHari" class="form-label">Harga Per Hari</label>
                        <input
                            type="number"
                            class="form-control"
                            id="hargaPerHari"
                            name="hargaPerHari"
                            value="<?= $data['hargaPerHari'] ?>"
                            required>
                        <!-- Menggunakan type "number" untuk validasi angka -->
                    </div>

                    <!-- Tombol untuk submit data -->
                    <button
                        type="submit"
                        class="btn btn-primary">
                        Simpan Perubahan
                    </button>

                    <!-- Tombol untuk kembali ke halaman daftar mobil -->
                    <a href="tampilMobil.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Menyertakan Bootstrap JS dan Popper.js untuk interaktivitas -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>