<?php
// Mengimpor file koneksi database dan pengecekan login
include '../connection/koneksi.php'; // Koneksi ke database
include '../controllers/prosesCekLogin.php'; // Pengecekan login pengguna

// Mengecek apakah form telah disubmit dengan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Mengambil data yang dikirimkan dari form menggunakan POST
    $kodePenyewaan = mysqli_real_escape_string($db, $_POST['kodePenyewaan']);
    $idKaryawan = mysqli_real_escape_string($db, $_POST['idKaryawan']);
    $idPelanggan = mysqli_real_escape_string($db, $_POST['idPelanggan']);
    $idMobil = mysqli_real_escape_string($db, $_POST['idMobil']);
    $tanggalSewa = mysqli_real_escape_string($db, $_POST['tanggalSewa']);
    $tanggalKembali = mysqli_real_escape_string($db, $_POST['tanggalKembali']);
    $statusPenyewaan = mysqli_real_escape_string($db, $_POST['statusPenyewaan']);
    
    // Mengambil dan membersihkan format Rupiah dari input totalBiaya
    $totalBiaya = str_replace(['Rp', '.', ' '], '', $_POST['totalBiaya']); // Menghapus simbol dan titik
    
    // Validasi apakah totalBiaya yang diinput adalah angka
    if (!is_numeric($totalBiaya)) {
        echo "<script>
                alert('Total biaya tidak valid!');
                window.location.href = '../view/editRental.php?kodePenyewaan=$kodePenyewaan';
              </script>";
        exit;
    }

    // Pastikan totalBiaya adalah angka dan konversi menjadi integer
    $totalBiaya = (int)$totalBiaya;

    // Validasi untuk memastikan semua data yang diperlukan sudah diisi
    if (empty($kodePenyewaan) || empty($idKaryawan) || empty($idPelanggan) || empty($idMobil) || empty($tanggalSewa) || empty($tanggalKembali) || empty($statusPenyewaan)) {
        echo "<script>
                alert('Semua data harus diisi!');
                window.location.href = '../view/editRental.php?kodePenyewaan=$kodePenyewaan';
              </script>";
        exit;
    }

    // Memulai transaksi
    mysqli_begin_transaction($db);

    try {
        // Mendapatkan idMobil sebelumnya untuk diperbarui statusnya
        $queryPrevMobil = "SELECT idMobil FROM penyewaan WHERE kodePenyewaan = '$kodePenyewaan'";
        $resultPrevMobil = mysqli_query($db, $queryPrevMobil);
        $prevMobil = mysqli_fetch_assoc($resultPrevMobil);
        $prevMobilId = $prevMobil['idMobil'];

        // Query SQL untuk memperbarui data penyewaan berdasarkan kodePenyewaan
        $query = "UPDATE penyewaan 
                  SET idKaryawan = '$idKaryawan', idPelanggan = '$idPelanggan', idMobil = '$idMobil', tanggalSewa = '$tanggalSewa', 
                      tanggalKembali = '$tanggalKembali', totalBiaya = '$totalBiaya', statusPenyewaan = '$statusPenyewaan' 
                  WHERE kodePenyewaan = '$kodePenyewaan'";

        // Eksekusi query untuk memperbarui data
        if (!mysqli_query($db, $query)) {
            throw new Exception("Error updating data in penyewaan table");
        }

        // Update status mobil yang sebelumnya disewa menjadi 'Tersedia'
        if ($prevMobilId !== $idMobil) {
            $updatePrevMobilQuery = "UPDATE mobil SET status = 'Tersedia' WHERE idMobil = '$prevMobilId'";
            if (!mysqli_query($db, $updatePrevMobilQuery)) {
                throw new Exception("Error updating previous mobil status to Tersedia");
            }
        }

        // Update status mobil yang baru menjadi 'Disewa'
        $updateNewMobilQuery = "UPDATE mobil SET status = 'Disewa' WHERE idMobil = '$idMobil'";
        if (!mysqli_query($db, $updateNewMobilQuery)) {
            throw new Exception("Error updating new mobil status to Disewa");
        }

        // Commit transaksi jika semua query berhasil
        mysqli_commit($db);

        // Jika semua sukses, tampilkan pesan sukses
        echo "<script>
                alert('Penyewaan berhasil diperbarui!');
                window.location.href = '../view/tampilRental.php'; // Redirect ke halaman tampil penyewaan
              </script>";

    } catch (Exception $e) {
        // Rollback jika terjadi error
        mysqli_rollback($db);

        // Menampilkan pesan error jika ada masalah
        echo "<script>
                alert('Terjadi kesalahan saat memperbarui penyewaan: " . $e->getMessage() . "');
                window.location.href = '../view/editRental.php?kodePenyewaan=$kodePenyewaan'; // Kembali ke halaman form
              </script>";
    }
}
?>
