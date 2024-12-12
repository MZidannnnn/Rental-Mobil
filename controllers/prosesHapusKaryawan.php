<?php
include '../controllers/prosesCekLogin.php';
include '../connection/koneksi.php';

// Ambil ID karyawan dari URL
$idKaryawan = $_GET['id'];

// Query untuk menghapus data karyawan berdasarkan ID
$query = "DELETE FROM karyawan WHERE idKaryawan = '$idKaryawan'";

// Eksekusi query
if (mysqli_query($db, $query)) {
    echo "<script>
            alert('Karyawan berhasil dihapus!');
            window.location.href = '../view/tampilKaryawan.php';
          </script>";
} else {
    echo "<script>
            alert('Terjadi kesalahan saat menghapus karyawan!');
            window.location.href = '../view/tampilKaryawan.php';
          </script>";
}
?>
