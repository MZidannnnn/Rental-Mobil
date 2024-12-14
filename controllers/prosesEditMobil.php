<?php
// Menyertakan file untuk memeriksa login dan koneksi ke database
include '../controllers/prosesCekLogin.php';
include '../connection/koneksi.php';

// Periksa apakah form telah disubmit dengan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari form input
    $idMobil = $_POST['idMobil']; // ID mobil (hidden field dari form)
    $merek = mysqli_real_escape_string($db, $_POST['merek']); // Merek mobil
    $model = mysqli_real_escape_string($db, $_POST['model']); // Model mobil
    $tahun = (int) $_POST['tahun']; // Tahun pembuatan mobil (dikonversi ke integer)
    $nomorPolisi = mysqli_real_escape_string($db, $_POST['nomorPolisi']); // Nomor polisi mobil
    $status = mysqli_real_escape_string($db, $_POST['status']); // Status mobil (misalnya "tersedia" atau "disewa")
    $hargaPerHari = (float) $_POST['hargaPerHari']; // Harga sewa per hari (dikonversi ke float)

    // Validasi: Pastikan semua data telah diisi
    if (empty($merek) || empty($model) || empty($tahun) || empty($nomorPolisi) || empty($status) || empty($hargaPerHari)) {
        // Jika ada data yang kosong, tampilkan pesan kesalahan dan kembali ke halaman edit
        echo "<script>
                alert('Semua data harus diisi!');
                window.location.href = '../view/editMobil.php?id=$idMobil';
              </script>";
        exit; // Hentikan eksekusi kode
    }

    // Periksa apakah nomor polisi yang dimasukkan sudah digunakan oleh mobil lain
    $checkQuery = "SELECT idMobil FROM mobil WHERE nomorPolisi = '$nomorPolisi' AND idMobil != '$idMobil'";
    $checkResult = mysqli_query($db, $checkQuery); // Eksekusi query

    // Jika nomor polisi sudah digunakan, tampilkan pesan kesalahan
    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>
                alert('Nomor polisi sudah digunakan, silakan pilih nomor polisi lain!');
                window.location.href = '../view/editMobil.php?id=$idMobil';
              </script>";
        exit; // Hentikan eksekusi kode
    }

    // Query SQL untuk memperbarui data mobil berdasarkan ID
    $query = "UPDATE mobil SET 
              merek = '$merek', 
              model = '$model', 
              tahun = '$tahun', 
              nomorPolisi = '$nomorPolisi', 
              status = '$status', 
              hargaPerHari = '$hargaPerHari' 
              WHERE idMobil = '$idMobil'";

    // Eksekusi query update
    if (mysqli_query($db, $query)) {
        // Jika update berhasil, tampilkan pesan sukses dan arahkan ke halaman daftar mobil
        echo "<script>
                alert('Data mobil berhasil diperbarui!');
                window.location.href = '../view/tampilMobil.php';
              </script>";
    } else {
        // Jika update gagal, tampilkan pesan kesalahan dan kembali ke halaman edit
        echo "<script>
                alert('Terjadi kesalahan saat memperbarui data mobil!');
                window.location.href = '../view/editMobil.php?id=$idMobil';
              </script>";
    }
}
?>
