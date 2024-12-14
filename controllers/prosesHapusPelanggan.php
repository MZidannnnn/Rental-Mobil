<?php
// Menyertakan file untuk memeriksa apakah pengguna sudah login
include '../controllers/prosesCekLogin.php';
// Menyertakan file koneksi ke database
include '../connection/koneksi.php';

// Mengambil ID pelanggan dari URL menggunakan metode GET
$idPelanggan = $_GET['id'];

// Query SQL untuk menghapus data pelanggan berdasarkan ID
$query = "DELETE FROM pelanggan WHERE idPelanggan = '$idPelanggan'";

// Menjalankan query ke database menggunakan fungsi mysqli_query
if (mysqli_query($db, $query)) {
    // Jika query berhasil dieksekusi, tampilkan pesan sukses dan arahkan pengguna ke halaman daftar pelanggan
    echo "<script>
            alert('Pelanggan berhasil dihapus!'); // Pesan sukses
            window.location.href = '../view/tampilPelanggan.php'; // Redirect ke halaman daftar pelanggan
          </script>";
} else {
    // Jika terjadi kesalahan saat menjalankan query, tampilkan pesan kesalahan
    echo "<script>
            alert('Terjadi kesalahan saat menghapus pelanggan!'); // Pesan kesalahan
            window.location.href = '../view/tampilPelanggan.php'; // Redirect ke halaman daftar pelanggan
          </script>";
}
?>
