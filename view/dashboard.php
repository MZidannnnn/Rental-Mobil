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

// Menambahkan filter berdasarkan status penyewaan
$statusFilter = isset($_GET['statusFilter']) ? $_GET['statusFilter'] : 'semua';
$queryTampilData = "SELECT p.kodePenyewaan, k.namaKaryawan AS nama_karyawan, 
                           m.merek AS nama_mobil, 
                           p.tanggalSewa, p.tanggalKembali, 
                           p.totalBiaya, p.statusPenyewaan, 
                           DATEDIFF(CURDATE(), p.tanggalKembali) AS terlambat 
                    FROM penyewaan p
                    JOIN karyawan k ON p.idKaryawan = k.idKaryawan
                    JOIN mobil m ON p.idMobil = m.idMobil
                    WHERE '$statusFilter' = 'semua' OR p.statusPenyewaan = '$statusFilter'";

$result = $db->query($queryTampilData);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selesaikanRental'])) {
    $kodePenyewaan = $_POST['kodePenyewaan'];
    $tanggalKembali = $_POST['tanggalKembali']; // Ambil tanggal kembali dari input

    // Periksa jika tanggal kembali sudah lewat
    if (strtotime($tanggalKembali) < strtotime(date('Y-m-d'))) {
        $updateStatusQuery = "UPDATE penyewaan SET statusPenyewaan = 'Terlambat' WHERE kodePenyewaan = '$kodePenyewaan'";
    } else {
        $updateStatusQuery = "UPDATE penyewaan SET statusPenyewaan = 'Selesai' WHERE kodePenyewaan = '$kodePenyewaan'";
    }

    // Eksekusi query untuk update status penyewaan
    $db->query($updateStatusQuery);

    // Ambil idMobil terkait penyewaan ini
    $getMobilQuery = "SELECT idMobil FROM penyewaan WHERE kodePenyewaan = '$kodePenyewaan'";
    $resultMobil = $db->query($getMobilQuery);
    if ($resultMobil->num_rows > 0) {
        $mobil = $resultMobil->fetch_assoc();
        $idMobil = $mobil['idMobil'];

        // Update status mobil menjadi 'Tersedia'
        $updateMobilQuery = "UPDATE mobil SET status = 'Tersedia' WHERE idMobil = '$idMobil'";
        $db->query($updateMobilQuery);
    }

    // Redirect setelah update
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Rental Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        table td {
            white-space: nowrap;
        }

        td {
            text-align: center;
        }

        .total-biaya {
            width: 150px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include '../components/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <!-- Top Bar -->
            <?php include '../components/topbar.php'; ?>

            <!-- Content Area -->
            <div class="container mt-4">
                <div class="row">
                    <!-- Card Jumlah Karyawan -->
                    <div class="col-md-3">
                        <div class="card info-card">
                            <div class="card-body">
                                <div class="icon">
                                    <i class="bi bi-person"></i>
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
                                    <i class="bi bi-person-lines-fill"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="card-title">Jumlah Pelanggan</h5>
                                    <p class="card-text fs-3"><?= $totalPelanggan; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Status Penyewaan -->
                <form method="GET" action="dashboard.php">
                    <label for="statusFilter" class="mt-4">Filter Status Penyewaan:</label>
                    <select id="statusFilter" name="statusFilter" class="form-select">
                        <option value="semua" <?= (isset($_GET['statusFilter']) && $_GET['statusFilter'] == 'semua') ? 'selected' : '' ?>>Semua</option>
                        <option value="Aktif" <?= (isset($_GET['statusFilter']) && $_GET['statusFilter'] == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                        <option value="Selesai" <?= (isset($_GET['statusFilter']) && $_GET['statusFilter'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                        <option value="Terlambat" <?= (isset($_GET['statusFilter']) && $_GET['statusFilter'] == 'Terlambat') ? 'selected' : '' ?>>Terlambat</option>
                    </select>
                    <button type="submit" class="btn btn-primary mt-2">Terapkan Filter</button>
                </form>

                <h2 class="mt-5">Daftar Rental Mobil</h2>
                <input type="text" id="searchInput" class="form-control mb-3" onkeyup="searchTable()" placeholder="Cari berdasarkan nama mobil...">


                <!-- Tabel Penyewaan -->
                <table class="table table-striped mt-3" id="tabelPenyewaan">
                    <thead>
                        <tr>
                            <th>Kode Penyewaan</th>
                            <th>Nama Karyawan</th>
                            <th>Nama Mobil</th>
                            <th>Tanggal Sewa</th>
                            <th>Tanggal Kembali</th>
                            <th>Total Biaya</th>
                            <th>Status Penyewaan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?= $row['kodePenyewaan']; ?></td>
                                <td><?= $row['nama_karyawan']; ?></td>
                                <td><?= $row['nama_mobil']; ?></td>
                                <td><?= $row['tanggalSewa']; ?></td>
                                <td><?= $row['tanggalKembali']; ?></td>
                                <td class="total-biaya"><?= 'Rp ' . number_format($row['totalBiaya'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php
                                    if ($row['statusPenyewaan'] == 'Aktif') {
                                        echo "<span class='badge bg-warning'>Aktif</span>";
                                    } elseif ($row['statusPenyewaan'] == 'Selesai') {
                                        echo "<span class='badge bg-success'>Selesai</span>";
                                    } else {
                                        echo "<span class='badge bg-danger'>Terlambat</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($row['statusPenyewaan'] == 'Aktif') : ?>
                                        <form method="POST" action="">
                                            <input type="hidden" name="kodePenyewaan" value="<?= $row['kodePenyewaan']; ?>">
                                            <input type="hidden" name="tanggalKembali" value="<?= $row['tanggalKembali']; ?>">
                                            <button type="submit" name="selesaikanRental" class="btn btn-primary btn-sm">Selesaikan Rental</button>
                                        </form>
                                    <?php elseif ($row['statusPenyewaan'] == 'Selesai') : ?>
                                        <span class="btn btn-success btn-sm">Selesai Dirental</span>
                                    <?php elseif ($row['statusPenyewaan'] == 'Terlambat') : ?>
                                        <span class="btn btn-danger btn-sm">Terlambat</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function searchTable() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("tabelPenyewaan");
            const tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName("td")[0]; // Kode Penyewaan di kolom ke-1
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

</body>

</html>