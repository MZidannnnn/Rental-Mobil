<?php
// Menyertakan file untuk memeriksa status login dan koneksi ke database
include '../controllers/prosesCekLogin.php';
include '../connection/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata untuk halaman HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Penyewaan - Rental Mobil</title>

    <!-- Mengimpor CSS Bootstrap untuk styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS untuk styling tambahan -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar (menu navigasi samping) -->
        <?php
        include '../components/sidebar.php'; // Menyertakan sidebar
        ?>

        <!-- Main Content (konten utama) -->
        <div class="flex-grow-1">
            <!-- Top Bar (bagian atas halaman) -->
            <?php
            include '../components/topbar.php'; // Menyertakan bar atas untuk tampilan header
            ?>

            <!-- Content Area (area konten utama) -->
            <div class="container mt-4">
                <!-- Judul halaman -->
                <h2 class="mb-2">Daftar Penyewaan</h2>

                <a href="tambahRental.php" class="btn btn-primary mb-2">
                    <i class="bi bi-plus-circle"></i> Tambah Penyewaan
                </a>
                <!-- Tabel untuk menampilkan data penyewaan -->
                <table class="table table-bordered table-striped">
                    <!-- Header tabel -->
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Penyewaan</th>
                            <th>ID Karyawan</th>
                            <th>ID Pelanggan</th>
                            <th>ID Mobil</th>
                            <th>Tanggal Sewa</th>
                            <th>Tanggal Kembali</th>
                            <th>Total Biaya</th>
                            <th>Status Penyewaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <!-- Body tabel, data akan diambil dari database -->
                    <tbody>
                        <?php
                        // Query untuk mendapatkan semua data dari tabel penyewaan
                        $query = "SELECT * FROM penyewaan";
                        $result = mysqli_query($db, $query);

                        // Inisialisasi nomor urut
                        $no = 1;

                        // Loop untuk menampilkan setiap data penyewaan dalam tabel
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";

                            // Menampilkan nomor urut
                            echo "<td>{$no}</td>";

                            // Menampilkan kode penyewaan
                            echo "<td>{$row['kodePenyewaan']}</td>";

                            // Menampilkan ID Karyawan
                            echo "<td>{$row['idKaryawan']}</td>";

                            // Menampilkan ID Pelanggan
                            echo "<td>{$row['idPelanggan']}</td>";

                            // Menampilkan ID Mobil
                            echo "<td>{$row['idMobil']}</td>";

                            // Menampilkan tanggal sewa
                            echo "<td>{$row['tanggalSewa']}</td>";

                            // Menampilkan tanggal kembali
                            echo "<td>{$row['tanggalKembali']}</td>";

                            // Menampilkan total biaya dengan format angka
                            echo "<td>
                            <div class='d-flex align-items-center'>
                                <span class='currency me-2'>Rp</span>
                                <span class='amount'>" . number_format($row['totalBiaya'], 0, ',', '.') . "</span>
                            </div>
                          </td>";


                            // Menampilkan status penyewaan
                            echo "<td>{$row['statusPenyewaan']}</td>";

                            // Menambahkan tombol aksi (Edit dan Hapus)
                            echo "<td>
                            <div class='d-flex'>
                                <!-- Tombol Edit dengan batas lebar dan tidak ada pemecahan baris -->
                                <a href='editRental.php?kodePenyewaan={$row['kodePenyewaan']}' class='btn btn-warning btn-sm me-2' style='max-width: 120px; white-space: nowrap;'>
                                    <i class='bi bi-pencil-square'></i> Edit
                                </a>
                                <!-- Tombol Hapus dengan batas lebar dan tidak ada pemecahan baris -->
                                <a href='../controllers/prosesHapusRental.php?kodePenyewaan={$row['kodePenyewaan']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")' style='max-width: 120px; white-space: nowrap;'>
                                    <i class='bi bi-trash'></i> Hapus
                                </a>
                            </div>
                          </td>";
                    



                            echo "</tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Mengimpor JavaScript untuk Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>