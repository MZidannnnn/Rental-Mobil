<?php
// Menyertakan file untuk memeriksa status login dan koneksi ke database
include '../controllers/prosesCekLogin.php'; // Memastikan pengguna sudah login
include '../connection/koneksi.php'; // Koneksi ke database
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata untuk halaman HTML -->
    <meta charset="UTF-8"> <!-- Menentukan karakter encoding -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Menyesuaikan tampilan dengan perangkat -->
    <title>Admin Pelanggan - Rental Mobil</title> <!-- Judul halaman -->

    <!-- Mengimpor CSS Bootstrap untuk styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Ikon Bootstrap -->
    
    <!-- Custom CSS untuk styling tambahan -->
    <link rel="stylesheet" href="../css/style.css"> <!-- Menyertakan CSS tambahan jika diperlukan -->
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar (menu navigasi samping) -->
        <?php
        include '../components/sidebar.php'; // Menyertakan sidebar untuk navigasi
        ?>

        <!-- Main Content (konten utama) -->
        <div class="flex-grow-1">
            <!-- Top Bar (bagian atas halaman) -->
            <?php
            include '../components/topbar.php'; // Menyertakan topbar untuk tampilan header
            ?>

            <!-- Content Area (area konten utama) -->
            <div class="container mt-4">
                <!-- Judul halaman -->
                <h2 class="mb-2">Daftar Pelanggan</h2>
                
                <!-- Tombol untuk menambah pelanggan baru -->
                <a href="tambahPelanggan.php" class="btn btn-primary mb-2">
                    <i class="bi bi-plus-circle"></i> Tambah Pelanggan
                </a>

                <!-- Tabel untuk menampilkan data pelanggan -->
                <table class="table table-bordered table-striped">
                    <!-- Header tabel -->
                    <thead class="table-dark">
                        <tr>
                            <th>No</th> <!-- Kolom nomor urut -->
                            <th>Nama Pelanggan</th> <!-- Kolom nama pelanggan -->
                            <th>Alamat</th> <!-- Kolom alamat pelanggan -->
                            <th>No Telepon</th> <!-- Kolom nomor telepon pelanggan -->
                            <th>Aksi</th> <!-- Kolom aksi untuk Edit dan Hapus -->
                        </tr>
                    </thead>
                    <!-- Body tabel, data akan diambil dari database -->
                    <tbody>
                        <?php
                        // Query untuk mendapatkan semua data pelanggan dari tabel 'pelanggan'
                        $query = "SELECT * FROM pelanggan"; 
                        // Eksekusi query dan simpan hasilnya dalam variabel $result
                        $result = mysqli_query($db, $query);
                        // Inisialisasi nomor urut
                        $no = 1;

                        // Loop untuk menampilkan setiap data pelanggan dalam tabel
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>"; // Membuka tag <tr> untuk baris tabel
                            
                            // Menampilkan nomor urut
                            echo "<td>{$no}</td>";
                            
                            // Menampilkan nama pelanggan
                            echo "<td>{$row['namaPelanggan']}</td>";
                            
                            // Menampilkan alamat pelanggan
                            echo "<td>{$row['alamat']}</td>";
                            
                            // Menampilkan nomor telepon pelanggan
                            echo "<td>{$row['noTelp']}</td>";
                            
                            // Menambahkan tombol aksi (Edit dan Hapus)
                            echo "<td>
                                <!-- Tombol Edit, mengarah ke halaman editPelanggan.php dengan ID pelanggan -->
                                <a href='editPelanggan.php?id={$row['idPelanggan']}' class='btn btn-warning btn-sm'>
                                    <i class='bi bi-pencil-square'></i> Edit
                                </a>
                                <!-- Tombol Hapus, mengarah ke prosesHapusPelanggan.php dengan ID pelanggan, menggunakan konfirmasi sebelum hapus -->
                                <a href='../controllers/prosesHapusPelanggan.php?id={$row['idPelanggan']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script> <!-- Popper.js untuk elemen seperti dropdown -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script> <!-- Bootstrap JS untuk interaktivitas -->
</body>

</html>
