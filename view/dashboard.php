<?php
include '../controllers/prosesCekLogin.php';
include '../connection/koneksi.php';

// Hitung jumlah data dari masing-masing tabel
$queryKaryawan = "SELECT COUNT(*) AS total FROM karyawan";
$resultKaryawan = $db->query($queryKaryawan);
$totalKaryawan = $resultKaryawan->fetch_assoc()['total'];

$queryMobil = "SELECT COUNT(*) AS total FROM mobil";
$resultMobil = $db->query($queryMobil);
$totalMobil = $resultMobil->fetch_assoc()['total'];

$queryPelanggan = "SELECT COUNT(*) AS total FROM pelanggan";
$resultPelanggan = $db->query($queryPelanggan);
$totalPelanggan = $resultPelanggan->fetch_assoc()['total'];

$queryPenyewaan = "SELECT COUNT(*) AS total FROM penyewaan";
$resultPenyewaan = $db->query($queryPenyewaan);
$totalPenyewaan = $resultPenyewaan->fetch_assoc()['total'];

$queryTampilData = "SELECT p.kodePenyewaan, k.namaKaryawan AS nama_karyawan, 
                           m.merek AS nama_mobil, 
                           p.tanggalSewa, p.tanggalKembali, 
                           p.totalBiaya, p.statusPenyewaan 
                    FROM penyewaan p
                    JOIN karyawan k ON p.idKaryawan = k.idKaryawan
                    JOIN mobil m ON p.idMobil = m.idMobil";
$result = $db->query($queryTampilData);
// Mengecek apakah query berhasil
// if (!$result) {
//     die("Query failed: " . $db->error); // Menampilkan pesan jika query gagal
// }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Rental Mobil</title>
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
                <div class="row">
                    <!-- Card Jumlah Karyawan -->
                    <div class="col-md-3">
                        <div class="card info-card">
                            <div class="card-body">
                                <div class="icon">
                                    <i class="bi bi-person"></i> <!-- Ikon Bootstrap untuk Karyawan -->
                                </div>
                                <div class="ms-3">
                                    <h5 class="card-title">Jumlah Karyawan</h5>
                                    <p class="card-text fs-3"><?= $totalKaryawan; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Jumlah Mobil -->
                    <div class="col-md-3">
                        <div class="card info-card">
                            <div class="card-body">
                                <div class="icon">
                                    <i class="bi bi-car-front"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="card-title">Jumlah Mobil</h5>
                                    <p class="card-text fs-3"><?= $totalMobil; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Jumlah Rental -->
                    <div class="col-md-3">
                        <div class="card info-card">
                            <div class="card-body">
                                <div class="icon">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="card-title">Jumlah Rental</h5>
                                    <p class="card-text fs-3"><?= $totalPenyewaan; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Jumlah Pelanggan -->
                    <div class="col-md-3">
                        <div class="card info-card">
                            <div class="card-body">
                                <div class="icon">
                                    <i class="bi bi-person-lines-fill"></i> <!-- Ikon Bootstrap untuk Pelanggan -->
                                </div>
                                <div class="ms-3">
                                    <h5 class="card-title">Jumlah Pelanggan</h5>
                                    <p class="card-text fs-3"><?= $totalPelanggan; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="mt-5">Daftar Rental Mobil</h2>
                <!-- Input untuk pencarian -->
                <input type="text" id="searchInput" class="form-control mb-3" onkeyup="searchTable()" placeholder="Cari berdasarkan nama mobil...">
                <!-- tabel penyewaan -->
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Penyewaan</th>
                            <th>Nama Karyawan</th>
                            <th>Nama Mobil</th>
                            <th>Tanggal Sewa</th>
                            <th>Tanggal Kembali</th>
                            <th>Total Biaya</th>
                            <th>Status Penyewaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Cek apakah data tersedia
                        if ($result->num_rows > 0) {
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['kodePenyewaan']); ?></td>
                                    <td><?= htmlspecialchars($row['nama_karyawan']); ?></td>
                                    <td><?= htmlspecialchars($row['nama_mobil']); ?></td>
                                    <td><?= date('d F Y', strtotime($row['tanggalSewa'])); ?></td>
                                    <td><?= date('d F Y', strtotime($row['tanggalKembali'])); ?></td>
                                    <td>Rp <?= number_format($row['totalBiaya'], 0, ',', '.'); ?></td>
                                    <td><?= htmlspecialchars($row['statusPenyewaan']); ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            // Jika data tidak ada, tampilkan pesan bahwa data tidak ditemukan
                            echo "<tr><td colspan='8' class='text-center'>Data penyewaan tidak ditemukan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bootstrap 5 JS, Popper.js, dan Bootstrap Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>