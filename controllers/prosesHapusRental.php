<?php
// Menyertakan file untuk memeriksa apakah pengguna sudah login
include '../controllers/prosesCekLogin.php';
// Menyertakan file koneksi ke database
include '../connection/koneksi.php';

// Mengambil kodePenyewaan dari URL menggunakan metode GET
$kodePenyewaan = $_GET['kodePenyewaan'];

// Query untuk mendapatkan idMobil yang terkait dengan penyewaan yang akan dihapus
$queryMobil = "SELECT idMobil FROM penyewaan WHERE kodePenyewaan = '$kodePenyewaan'";
$resultMobil = mysqli_query($db, $queryMobil);

// Mengecek apakah query berhasil dan data ditemukan
if ($resultMobil && mysqli_num_rows($resultMobil) > 0) {
    $rowMobil = mysqli_fetch_assoc($resultMobil);
    $idMobil = $rowMobil['idMobil'];

    // Memulai transaksi
    mysqli_begin_transaction($db);

    try {
        // Mengupdate status mobil menjadi 'Tersedia'
        $updateMobilQuery = "UPDATE mobil SET status = 'Tersedia' WHERE idMobil = '$idMobil'";
        if (!mysqli_query($db, $updateMobilQuery)) {
            throw new Exception("Error updating mobil status to Tersedia");
        }

        // Query SQL untuk menghapus data penyewaan berdasarkan kodePenyewaan
        $query = "DELETE FROM penyewaan WHERE kodePenyewaan = '$kodePenyewaan'";

        // Menjalankan query untuk menghapus data penyewaan
        if (!mysqli_query($db, $query)) {
            throw new Exception("Error deleting data from penyewaan table");
        }

        // Commit transaksi jika semua query berhasil
        mysqli_commit($db);

        // Jika semua sukses, tampilkan pesan sukses dan arahkan ke halaman tampilRental
        echo "<script>
                alert('Penyewaan berhasil dihapus dan status mobil diubah menjadi Tersedia!');
                window.location.href = '../view/tampilRental.php'; // Redirect ke halaman daftar rental
              </script>";

    } catch (Exception $e) {
        // Rollback jika terjadi error
        mysqli_rollback($db);

        // Menampilkan pesan error jika ada masalah
        echo "<script>
                alert('Terjadi kesalahan saat menghapus penyewaan: " . $e->getMessage() . "');
                window.location.href = '../view/tampilRental.php'; // Redirect ke halaman daftar rental
              </script>";
    }
} else {
    // Jika tidak ditemukan mobil terkait dengan penyewaan
    echo "<script>
            alert('Tidak ditemukan mobil terkait dengan penyewaan ini!');
            window.location.href = '../view/tampilRental.php'; // Redirect ke halaman daftar rental
          </script>";
}
?>
