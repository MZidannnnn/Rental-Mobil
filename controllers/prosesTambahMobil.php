<?php
// Mengimpor file koneksi database dan pengecekan login
include '../connection/koneksi.php'; // Koneksi ke database
include '../controllers/prosesCekLogin.php'; // Pengecekan login pengguna

// Mengecek apakah form telah disubmit dengan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data yang dikirimkan dari form menggunakan POST
    // Fungsi mysqli_real_escape_string digunakan untuk mencegah SQL Injection
    $merek = mysqli_real_escape_string($db, $_POST['merek']);  // Mengambil data merek mobil
    $model = mysqli_real_escape_string($db, $_POST['model']); // Mengambil data model mobil
    $tahun = mysqli_real_escape_string($db, $_POST['tahun']); // Mengambil data tahun mobil
    $nomorPolisi = mysqli_real_escape_string($db, $_POST['nomorPolisi']); // Mengambil nomor polisi mobil
    $status = mysqli_real_escape_string($db, $_POST['status']); // Mengambil status mobil (tersedia/sudah disewa)
    $hargaPerHari = mysqli_real_escape_string($db, $_POST['hargaPerHari']); // Mengambil harga sewa per hari mobil

    // Validasi data: Pastikan semua field diisi
    if (empty($merek) || empty($model) || empty($tahun) || empty($nomorPolisi) || empty($status) || empty($hargaPerHari)) {
        // Jika ada data yang kosong, tampilkan pesan error dan kembali ke halaman form
        echo "<script>
                alert('Semua data harus diisi!');
                window.location.href = '../view/tambahMobil.php'; // Kembali ke halaman form tambah mobil
              </script>";
        exit; // Menghentikan eksekusi lebih lanjut jika ada data yang kosong
    }

    // Query SQL untuk menambahkan data mobil ke dalam tabel mobil
    $query = "INSERT INTO mobil (merek, model, tahun, nomorPolisi, status, hargaPerHari) 
              VALUES ('$merek', '$model', '$tahun', '$nomorPolisi', '$status', '$hargaPerHari')";

    // Eksekusi query untuk menambahkan data
    if (mysqli_query($db, $query)) {
        // Jika query berhasil dieksekusi, tampilkan pesan sukses dan alihkan ke halaman daftar mobil
        echo "<script>
                alert('Mobil berhasil ditambahkan!');
                window.location.href = '../view/tampilMobil.php'; // Redirect ke halaman tampil mobil
              </script>";
    } else {
        // Jika terjadi kesalahan saat eksekusi query, tampilkan pesan error
        echo "<script>
                alert('Terjadi kesalahan saat menambahkan mobil!');
                window.location.href = '../view/tambahMobil.php'; // Kembali ke halaman form tambah mobil
              </script>";
    }
}
?>
