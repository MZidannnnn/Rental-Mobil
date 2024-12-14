<?php
// Menyertakan file untuk memeriksa apakah pengguna sudah login
include '../controllers/prosesCekLogin.php';

// Menyertakan file koneksi database
include '../connection/koneksi.php';

// Mengambil ID pelanggan dari URL menggunakan metode GET
$idPelanggan = $_GET['id'];

// Membuat query SQL untuk mengambil data pelanggan berdasarkan ID
$query = "SELECT * FROM pelanggan WHERE idPelanggan = '$idPelanggan'";
$result = mysqli_query($db, $query); // Menjalankan query ke database

// Mengambil hasil query sebagai array asosiatif
$data = mysqli_fetch_assoc($result);

// Validasi jika data tidak ditemukan (misalnya ID tidak valid atau tidak ada di database)
if (!$data) {
    // Jika data tidak ditemukan, tampilkan pesan peringatan dan alihkan ke halaman daftar pelanggan
    echo "<script>
            alert('Data pelanggan tidak ditemukan!');
            window.location.href = 'tampilPelanggan.php';
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
    <title>Edit Data Pelanggan</title>

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

            <!-- Area untuk form edit pelanggan -->
            <div class="container mt-4">
                <h2>Edit Data Pelanggan</h2> <!-- Judul halaman -->

                <!-- Form untuk mengedit data pelanggan -->
                <form action="../controllers/prosesEditPelanggan.php" method="POST">
                    <!-- Field tersembunyi untuk menyimpan ID pelanggan -->
                    <input type="hidden" name="idPelanggan" value="<?= $data['idPelanggan'] ?>">

                    <!-- Input untuk Nama Pelanggan -->
                    <div class="mb-3">
                        <label for="namaPelanggan" class="form-label">Nama Pelanggan</label>
                        <input
                            type="text"
                            class="form-control"
                            id="namaPelanggan"
                            name="namaPelanggan"
                            value="<?= $data['namaPelanggan'] ?>"
                            required>
                        <!-- Value default diambil dari database -->
                    </div>

                    <!-- Input untuk Alamat Pelanggan -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea
                            class="form-control"
                            id="alamat"
                            name="alamat"
                            rows="3"
                            required><?= $data['alamat'] ?></textarea>
                        <!-- Value default diambil dari database -->
                    </div>

                    <!-- Input untuk Nomor Telepon Pelanggan -->
                    <div class="mb-3">
                        <label for="noTelp" class="form-label">Nomor Telepon</label>
                        <input
                            type="text"
                            class="form-control"
                            id="noTelp"
                            name="noTelp"
                            value="<?= $data['noTelp'] ?>"
                            required>
                        <!-- Value default diambil dari database -->
                    </div>

                    <!-- Tombol untuk submit data -->
                    <button
                        type="submit"
                        class="btn btn-primary">
                        Simpan Perubahan
                    </button>

                    <!-- Tombol untuk kembali ke halaman daftar pelanggan -->
                    <a href="tampilPelanggan.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Menyertakan Bootstrap JS dan Popper.js untuk interaktivitas -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
