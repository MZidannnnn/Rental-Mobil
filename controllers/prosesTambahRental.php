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
                window.location.href = '../view/tambahRental.php';
              </script>";
        exit;
    }

    // Pastikan totalBiaya adalah angka dan konversi menjadi integer
    $totalBiaya = (int)$totalBiaya;

    // Validasi untuk memastikan semua data yang diperlukan sudah diisi
    if (empty($kodePenyewaan) || empty($idKaryawan) || empty($idPelanggan) || empty($idMobil) || empty($tanggalSewa) || empty($tanggalKembali) || empty($statusPenyewaan)) {
        echo "<script>
                alert('Semua data harus diisi!');
                window.location.href = '../view/tambahRental.php';
              </script>";
        exit;
    }

    // Memulai transaksi
    mysqli_begin_transaction($db);

    try {
        // Query SQL untuk menambahkan data penyewaan ke dalam tabel penyewaan
        $query = "INSERT INTO penyewaan (kodePenyewaan, idKaryawan, idPelanggan, idMobil, tanggalSewa, tanggalKembali, totalBiaya, statusPenyewaan) 
                  VALUES ('$kodePenyewaan', '$idKaryawan', '$idPelanggan', '$idMobil', '$tanggalSewa', '$tanggalKembali', '$totalBiaya', '$statusPenyewaan')";
        
        // Eksekusi query untuk menambahkan data
        if (!mysqli_query($db, $query)) {
            throw new Exception("Error inserting data into penyewaan table");
        }

        // Jika ada query lain yang perlu dijalankan (misalnya update tabel lain atau insert tambahan)
        // Berikut adalah contoh query kedua (misalnya mengupdate status mobil setelah penyewaan)
        $updateMobilQuery = "UPDATE mobil SET status = 'disewa' WHERE idMobil = '$idMobil'";
        if (!mysqli_query($db, $updateMobilQuery)) {
            throw new Exception("Error updating mobil status");
        }

        // Commit transaksi jika semua query berhasil
        mysqli_commit($db);

        // Jika semua sukses, tampilkan pesan sukses
        echo "<script>
                alert('Penyewaan berhasil ditambahkan!');
                window.location.href = '../view/tampilRental.php'; // Redirect ke halaman tampil penyewaan
              </script>";

    } catch (Exception $e) {
        // Rollback jika terjadi error
        mysqli_rollback($db);

        // Menampilkan pesan error jika ada masalah
        echo "<script>
                alert('Terjadi kesalahan saat menambahkan penyewaan: " . $e->getMessage() . "');
                window.location.href = '../view/tambahRental.php'; // Kembali ke halaman form
              </script>";
    }
}
?>
