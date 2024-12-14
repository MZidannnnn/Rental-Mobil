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
    <title>Admin Mobil - Rental Mobil</title>

    <!-- Mengimpor CSS Bootstrap untuk styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Ikon Bootstrap -->
    
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
                <h2 class="mb-2">Daftar Mobil</h2>
                
                <!-- Tombol untuk menambah mobil baru -->
                <a href="tambahMobil.php" class="btn btn-primary mb-2">
                    <i class="bi bi-plus-circle"></i> Tambah Mobil
                </a>

                <!-- Tabel untuk menampilkan data mobil -->
                <table class="table table-bordered table-striped">
                    <!-- Header tabel -->
                    <thead class="table-dark">
                        <tr>
                            <th>No</th> <!-- Kolom nomor urut -->
                            <th>Merek Mobil</th> <!-- Kolom merek mobil -->
                            <th>Model</th> <!-- Kolom model mobil -->
                            <th>Tahun</th> <!-- Kolom tahun mobil -->
                            <th>Nomor Polisi</th> <!-- Kolom nomor polisi mobil -->
                            <th>Status</th> <!-- Kolom status mobil -->
                            <th>Harga Per Hari</th> <!-- Kolom harga sewa mobil per hari -->
                            <th>Aksi</th> <!-- Kolom aksi untuk Edit dan Hapus -->
                        </tr>
                    </thead>
                    <!-- Body tabel, data akan diambil dari database -->
                    <tbody>
                        <?php
                        // Query untuk mendapatkan semua data mobil dari tabel 'mobil'
                        $query = "SELECT * FROM mobil"; 
                        // Eksekusi query dan simpan hasilnya dalam variabel $result
                        $result = mysqli_query($db, $query);
                        // Inisialisasi nomor urut
                        $no = 1;

                        // Loop untuk menampilkan setiap data mobil dalam tabel
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>"; // Membuka tag <tr> untuk baris tabel
                            
                            // Menampilkan nomor urut
                            echo "<td>{$no}</td>";
                            
                            // Menampilkan merek mobil
                            echo "<td>{$row['merek']}</td>";
                            
                            // Menampilkan model mobil
                            echo "<td>{$row['model']}</td>";
                            
                            // Menampilkan tahun mobil
                            echo "<td>{$row['tahun']}</td>";
                            
                            // Menampilkan nomor polisi mobil
                            echo "<td>{$row['nomorPolisi']}</td>";
                            
                            // Menampilkan status mobil
                            echo "<td>{$row['status']}</td>";
                            
                            // Menampilkan harga per hari dengan format angka yang mudah dibaca
                            echo "<td>Rp " . number_format($row['hargaPerHari'], 0, ',', '.') . "</td>";
                            
                            // Menambahkan tombol aksi (Edit dan Hapus)
                            echo "<td>
                                <!-- Tombol Edit, mengarah ke halaman editMobil.php dengan ID mobil -->
                                <a href='editMobil.php?id={$row['idMobil']}' class='btn btn-warning btn-sm'>
                                    <i class='bi bi-pencil-square'></i> Edit
                                </a>
                                <!-- Tombol Hapus, mengarah ke prosesHapusMobil.php dengan ID mobil, menggunakan konfirmasi sebelum hapus -->
                                <a href='../controllers/prosesHapusMobil.php?id={$row['idMobil']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
                                    <i class='bi bi-trash'></i> Hapus
                                </a>
                            </td>";
                            
                            echo "</tr>"; // Menutup tag <tr> untuk baris ini
                            $no++; // Menambah nomor urut untuk baris berikutnya
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    </div>

    <!-- Mengimpor JavaScript untuk Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
