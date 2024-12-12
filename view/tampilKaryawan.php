<?php
include '../controllers/prosesCekLogin.php';
include '../connection/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Karyawan - Rental Mobil</title>
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
                <h2 class="mb-2">Daftar Karyawan</h2>
                <!-- Tombol Tambah Karyawan -->
                <a href="tambahKaryawan.php" class="btn btn-primary mb-2">
                    <i class="bi bi-plus-circle"></i> Tambah Karyawan
                </a>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Username</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query untuk mendapatkan data karyawan
                        $query = "SELECT * FROM karyawan";
                        $result = mysqli_query($db, $query);
                        $no = 1;

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$no}</td>";
                            echo "<td>{$row['namaKaryawan']}</td>";
                            echo "<td>{$row['username']}</td>";
                            echo "<td>{$row['noTelp']}</td>";
                            echo "<td>{$row['alamat']}</td>";
                            echo "<td>
                                <a href='editKaryawan.php?id={$row['idKaryawan']}' class='btn btn-warning btn-sm'>
                                    <i class='bi bi-pencil-square'></i> Edit
                                </a>
                                <a href='../controllers/prosesHapusKaryawan.php?id={$row['idKaryawan']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
                                    <i class='bi bi-trash'></i> Hapus
                                </a>
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

    </div>

    <!-- Bootstrap 5 JS, Popper.js, dan Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>