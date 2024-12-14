<?php
include '../controllers/prosesCekLogin.php';
include '../connection/koneksi.php';

// Ambil ID karyawan dari URL
$idMobil = $_GET['id'];

// Query untuk menghapus data karyawan berdasarkan ID
$query = "DELETE FROM mobil WHERE idMobil = '$idMobil'";

// Eksekusi query
if (mysqli_query($db, $query)) {
    echo "<script>
            alert('Mobil berhasil dihapus!');
            window.location.href = '../view/tampilMobil.php';
          </script>";
} else {
    echo "<script>
            alert('Terjadi kesalahan saat menghapus Mobil!');
            window.location.href = '../view/tampilMobil.php';
          </script>";
}
?>
