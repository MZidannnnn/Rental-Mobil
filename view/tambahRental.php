<?php
// Menyertakan file untuk memeriksa login dan koneksi database
include '../controllers/prosesCekLogin.php';  // Memeriksa apakah user sudah login
include '../connection/koneksi.php'; // Menyertakan file koneksi database
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penyewaan - Admin</title>

    <!-- Menyertakan file CSS Bootstrap 5 untuk styling halaman -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Ikon -->
    <link rel="stylesheet" href="../css/style.css"> <!-- Style kustom -->
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include '../components/sidebar.php'; // Menyertakan sidebar 
        ?>

        <!-- Konten Utama -->
        <div class="flex-grow-1">
            <!-- Top Bar -->
            <?php include '../components/topbar.php'; // Menyertakan top bar 
            ?>

            <!-- Area Konten -->
            <div class="container mt-4">
                <h2 class="mb-4">Tambah Penyewaan</h2>
                <!-- Form untuk tambah penyewaan -->
                <form action="../controllers/prosesTambahRental.php" method="POST">
                    <!-- Input untuk kode penyewaan -->
                    <div class="mb-3">
                        <label for="kodePenyewaan" class="form-label">Kode Penyewaan</label>
                        <input type="text" class="form-control" id="kodePenyewaan" name="kodePenyewaan" required>
                    </div>

                    <!-- Input untuk memilih karyawan -->
                    <div class="mb-3">
                        <label for="idKaryawan" class="form-label">Karyawan</label>
                        <select class="form-select" id="idKaryawan" name="idKaryawan" required>
                            <option value="" selected disabled>Pilih Karyawan</option>
                            <?php
                            $queryKaryawan = "SELECT idKaryawan, namaKaryawan FROM karyawan";
                            $resultKaryawan = mysqli_query($db, $queryKaryawan);
                            while ($rowKaryawan = mysqli_fetch_assoc($resultKaryawan)) {
                                echo "<option value='{$rowKaryawan['idKaryawan']}'>{$rowKaryawan['namaKaryawan']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Input untuk memilih pelanggan -->
                    <div class="mb-3">
                        <label for="idPelanggan" class="form-label">Pelanggan</label>
                        <select class="form-select" id="idPelanggan" name="idPelanggan" required>
                            <option value="" selected disabled>Pilih Pelanggan</option>
                            <?php
                            $queryPelanggan = "SELECT idPelanggan, namaPelanggan FROM pelanggan";
                            $resultPelanggan = mysqli_query($db, $queryPelanggan);
                            while ($rowPelanggan = mysqli_fetch_assoc($resultPelanggan)) {
                                echo "<option value='{$rowPelanggan['idPelanggan']}'>{$rowPelanggan['namaPelanggan']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Input untuk memilih mobil -->
                    <div class="mb-3">
                        <label for="idMobil" class="form-label">Mobil</label>
                        <select class="form-select" id="idMobil" name="idMobil" required>
                            <option value="" selected disabled>Pilih Mobil</option>
                            <?php
                            $queryMobil = "SELECT idMobil, merek, model, hargaPerHari FROM mobil WHERE status = 'Tersedia'";
                            $resultMobil = mysqli_query($db, $queryMobil);
                            while ($rowMobil = mysqli_fetch_assoc($resultMobil)) {
                                echo "<option value='{$rowMobil['idMobil']}' data-harga='{$rowMobil['hargaPerHari']}'>
                    {$rowMobil['merek']} {$rowMobil['model']}
                  </option>";
                            }
                            ?>
                        </select>
                    </div>


                    <!-- Input untuk memilih tanggal sewa -->
                    <div class="mb-3">
                        <label for="tanggalSewa" class="form-label">Tanggal Sewa</label>
                        <input type="date" class="form-control" id="tanggalSewa" name="tanggalSewa" required>
                    </div>

                    <!-- Input untuk memilih tanggal kembali -->
                    <div class="mb-3">
                        <label for="tanggalKembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" id="tanggalKembali" name="tanggalKembali" required>
                    </div>

                    <!-- Input untuk menampilkan total biaya -->
                    <div class="mb-3">
                        <label for="totalBiaya" class="form-label">Total Biaya</label>
                        <input type="text" class="form-control" id="totalBiaya" name="totalBiaya" readonly>
                    </div>

                    <!-- Input untuk memilih status penyewaan -->
                    <div class="mb-3">
                        <label for="statusPenyewaan" class="form-label">Status Penyewaan</label>
                        <select class="form-select" id="statusPenyewaan" name="statusPenyewaan" required>
                            <option value="" selected disabled>Pilih Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Terlambat">Terlambat</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>

                    <!-- Tombol untuk menyimpan data penyewaan -->
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="tampilPenyewaan.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script untuk menghitung biaya sewa -->
    <script>
        document.getElementById('idMobil').addEventListener('change', hitungBiaya);
        document.getElementById('tanggalSewa').addEventListener('change', hitungBiaya);
        document.getElementById('tanggalKembali').addEventListener('change', hitungBiaya);

        function hitungBiaya() {
            const tanggalSewaValue = document.getElementById('tanggalSewa').value;
            const tanggalKembaliValue = document.getElementById('tanggalKembali').value;

            // Validasi jika tanggal belum diisi
            if (!tanggalSewaValue || !tanggalKembaliValue) {
                document.getElementById('totalBiaya').value = formatRupiah(0); // Default ke Rp 0
                return;
            }

            const tanggalSewa = new Date(tanggalSewaValue);
            const tanggalKembali = new Date(tanggalKembaliValue);

            // Validasi jika tanggal kembali lebih kecil dari tanggal sewa
            if (tanggalKembali < tanggalSewa) {
                document.getElementById('totalBiaya').value = formatRupiah(0); // Default ke Rp 0
                alert("Tanggal kembali harus lebih besar atau sama dengan tanggal sewa.");
                return;
            }

            // Hitung durasi hari
            const diffTime = tanggalKembali - tanggalSewa;
            const durasiHari = Math.ceil(diffTime / (1000 * 3600 * 24)) + 1;

            // Ambil harga mobil dari data-harga
            const idMobil = document.getElementById('idMobil');
            const selectedOption = idMobil.options[idMobil.selectedIndex];
            const hargaPerHari = parseFloat(selectedOption?.getAttribute('data-harga'));

            // Validasi harga mobil
            if (isNaN(hargaPerHari)) {
                document.getElementById('totalBiaya').value = formatRupiah(0); // Default ke Rp 0
                return;
            }

            // Hitung total biaya
            const totalBiaya = durasiHari * hargaPerHari;

            // Tampilkan dalam format Rupiah
            document.getElementById('totalBiaya').value = formatRupiah(totalBiaya);
        }

        function formatRupiah(angka) {
            return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>