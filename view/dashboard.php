<?php
include '../controllers/prosesCekLogin.php';
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
                                    <p class="card-text fs-3">120</p>
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
                                    <p class="card-text fs-3">35</p>
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
                                    <p class="card-text fs-3">50</p>
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
                                    <p class="card-text fs-3">200</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="mt-5">Daftar Rental Mobil</h2>
                <!-- Input untuk pencarian -->
                <input type="text" id="searchInput" class="form-control mb-3" onkeyup="searchTable()" placeholder="Cari berdasarkan nama mobil...">

                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Mobil</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Harga Sewa</th>
                            <th>Tanggal Sewa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Honda Civic</td>
                            <td>Sedan</td>
                            <td>Tersedia</td>
                            <td>Rp 500.000</td>
                            <td>12 Desember 2024</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Toyota Avanza</td>
                            <td>MPV</td>
                            <td>Sedang Disewa</td>
                            <td>Rp 350.000</td>
                            <td>11 Desember 2024</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>BMW X5</td>
                            <td>SUV</td>
                            <td>Tersedia</td>
                            <td>Rp 1.200.000</td>
                            <td>12 Desember 2024</td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>

        <!-- Bootstrap 5 JS, Popper.js, dan Bootstrap Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>