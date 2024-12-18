<?php
// Menyertakan file untuk memeriksa login dan koneksi database
include '../controllers/prosesCekLogin.php';
include '../connection/koneksi.php';

// Mendapatkan kodePenyewaan dari URL
$kodePenyewaan = $_GET['kodePenyewaan'] ?? null;
// Validasi kodePenyewaan
if (!$kodePenyewaan) {
    echo "<script>
            alert('Kode penyewaan tidak valid!');
            window.location.href = 'tampilRental.php';
          </script>";
    exit;
}

// Ambil data penyewaan berdasarkan kodePenyewaan
$query = "SELECT * FROM penyewaan WHERE kodePenyewaan = '$kodePenyewaan'";
$result = mysqli_query($db, $query);
$dataPenyewaan = mysqli_fetch_assoc($result);

if (!$dataPenyewaan) {
    echo "<script>
            alert('Data penyewaan tidak ditemukan!');
            window.location.href = 'tampilRental.php';
          </script>";
    exit;
}

// Ambil data karyawan berdasarkan idKaryawan
$idKaryawan = $dataPenyewaan['idKaryawan'];
$queryKaryawan = "SELECT idKaryawan, namaKaryawan FROM karyawan";
$resultKaryawan = mysqli_query($db, $queryKaryawan);

// Ambil data pelanggan berdasarkan idPelanggan
$idPelanggan = $dataPenyewaan['idPelanggan'];
$queryPelanggan = "SELECT idPelanggan, namaPelanggan FROM pelanggan";
$resultPelanggan = mysqli_query($db, $queryPelanggan);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penyewaan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="d-flex">
        <?php include '../components/sidebar.php'; ?>
        <div class="flex-grow-1">
            <?php include '../components/topbar.php'; ?>
            <div class="container mt-4">
                <h2 class="mb-4">Edit Penyewaan</h2>
                <form action="../controllers/prosesEditRental.php" method="POST">
                    <div class="mb-3">
                        <label for="kodePenyewaan" class="form-label">Kode Penyewaan</label>
                        <input type="text" class="form-control" id="kodePenyewaan" name="kodePenyewaan" value="<?= $dataPenyewaan['kodePenyewaan'] ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="idMobil" class="form-label">Mobil</label>
                        <select class="form-select" id="idMobil" name="idMobil" required>
                            <option value="" disabled>Pilih Mobil</option>
                            <?php
                            // Menampilkan mobil yang sebelumnya disewa
                            // Mengambil data mobil yang digunakan pada penyewaan sebelumnya
                            $selectedMobilId = $dataPenyewaan['idMobil'];  // ID mobil yang sebelumnya disewa

                            // Query untuk mendapatkan mobil yang statusnya 'disewa' dan terpilih sebelumnya
                            $queryMobil = "SELECT idMobil, merek, model, hargaPerHari FROM mobil WHERE idMobil = '$selectedMobilId' OR status = 'Tersedia'";
                            $resultMobil = mysqli_query($db, $queryMobil);

                            // Memeriksa apakah query berhasil dan menghasilkan data
                            if ($resultMobil) {
                                while ($rowMobil = mysqli_fetch_assoc($resultMobil)) {
                                    // Menandai opsi yang dipilih (jika idMobil sesuai dengan yang ada di data penyewaan)
                                    $selected = $rowMobil['idMobil'] == $selectedMobilId ? 'selected' : '';
                                    echo "<option value='{$rowMobil['idMobil']}' data-harga='{$rowMobil['hargaPerHari']}' $selected>{$rowMobil['merek']} {$rowMobil['model']}</option>";
                                }
                            } else {
                                echo "<option disabled>Mobil tidak tersedia</option>";
                            }
                            ?>
                        </select>


                    </div>
                    <div class="mb-3">
                        <label for="tanggalSewa" class="form-label">Tanggal Sewa</label>
                        <input type="date" class="form-control" id="tanggalSewa" name="tanggalSewa" value="<?= $dataPenyewaan['tanggalSewa'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalKembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" id="tanggalKembali" name="tanggalKembali" value="<?= $dataPenyewaan['tanggalKembali'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="totalBiaya" class="form-label">Total Biaya</label>
                        <input type="text" class="form-control" id="totalBiaya" name="totalBiaya" value="<?= $dataPenyewaan['totalBiaya'] ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="statusPenyewaan" class="form-label">Status Penyewaan</label>
                        <select class="form-select" id="statusPenyewaan" name="statusPenyewaan" required>
                            <option value="" disabled>Pilih Status</option>
                            <option value="Aktif" <?= $dataPenyewaan['statusPenyewaan'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="Selesai" <?= $dataPenyewaan['statusPenyewaan'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                            <option value="Terlambat" <?= $dataPenyewaan['statusPenyewaan'] == 'Terlambat' ? 'selected' : '' ?>>Terlambat</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="idKaryawan" class="form-label">Nama Karyawan</label>
                        <select class="form-select" id="idKaryawan" name="idKaryawan" required>
                            <option value="" disabled>Pilih Karyawan</option>
                            <?php
                            while ($rowKaryawan = mysqli_fetch_assoc($resultKaryawan)) {
                                $selected = $rowKaryawan['idKaryawan'] == $dataPenyewaan['idKaryawan'] ? 'selected' : '';
                                echo "<option value='{$rowKaryawan['idKaryawan']}' $selected>{$rowKaryawan['namaKaryawan']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="idPelanggan" class="form-label">Nama Pelanggan</label>
                        <select class="form-select" id="idPelanggan" name="idPelanggan" required>
                            <option value="" disabled>Pilih Pelanggan</option>
                            <?php
                            while ($rowPelanggan = mysqli_fetch_assoc($resultPelanggan)) {
                                $selected = $rowPelanggan['idPelanggan'] == $dataPenyewaan['idPelanggan'] ? 'selected' : '';
                                echo "<option value='{$rowPelanggan['idPelanggan']}' $selected>{$rowPelanggan['namaPelanggan']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="tampilRental.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", hitungBiaya);
        document.getElementById('idMobil').addEventListener('change', hitungBiaya);
        document.getElementById('tanggalSewa').addEventListener('change', hitungBiaya);
        document.getElementById('tanggalKembali').addEventListener('change', hitungBiaya);

        function hitungBiaya() {
            const tanggalSewaValue = document.getElementById('tanggalSewa').value;
            const tanggalKembaliValue = document.getElementById('tanggalKembali').value;

            if (!tanggalSewaValue || !tanggalKembaliValue) {
                document.getElementById('totalBiaya').value = formatRupiah(0);
                return;
            }

            const tanggalSewa = new Date(tanggalSewaValue);
            const tanggalKembali = new Date(tanggalKembaliValue);

            if (tanggalKembali < tanggalSewa) {
                document.getElementById('totalBiaya').value = formatRupiah(0);
                alert("Tanggal kembali harus lebih besar atau sama dengan tanggal sewa.");
                return;
            }

            const diffTime = tanggalKembali - tanggalSewa;
            const durasiHari = Math.ceil(diffTime / (1000 * 3600 * 24)) + 1;

            const idMobil = document.getElementById('idMobil');
            const selectedOption = idMobil.options[idMobil.selectedIndex];
            const hargaPerHari = parseFloat(selectedOption?.getAttribute('data-harga'));

            if (isNaN(hargaPerHari)) {
                document.getElementById('totalBiaya').value = formatRupiah(0);
                return;
            }

            const totalBiaya = durasiHari * hargaPerHari;
            document.getElementById('totalBiaya').value = formatRupiah(totalBiaya);
        }

        function formatRupiah(angka) {
            return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>
</body>

</html>