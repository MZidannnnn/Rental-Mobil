<?php
// Mengimpor file koneksi database dan pengecekan login
include '../connection/koneksi.php'; // Koneksi ke database, pastikan file koneksi sesuai dengan pengaturan Anda
include '../controllers/prosesCekLogin.php'; // Pengecekan login pengguna agar hanya pengguna yang terautentikasi yang bisa mengakses halaman ini

// Mengecek apakah form telah disubmit dengan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data yang dikirimkan dari form menggunakan POST
    // Fungsi mysqli_real_escape_string digunakan untuk mencegah SQL Injection dengan mengamankan input pengguna
    $namaPelanggan = mysqli_real_escape_string($db, $_POST['namaPelanggan']); // Mengambil data nama pelanggan yang diinputkan
    $alamat = mysqli_real_escape_string($db, $_POST['alamat']); // Mengambil data alamat pelanggan yang diinputkan
    $noTelp = mysqli_real_escape_string($db, $_POST['noTelp']); // Mengambil data nomor telepon pelanggan yang diinputkan

    // Validasi data: Pastikan semua field diisi
    // Jika ada data yang kosong, tampilkan pesan error dan kembali ke halaman form tambah pelanggan
    if (empty($namaPelanggan) || empty($alamat) || empty($noTelp)) {
        echo "<script>
                alert('Semua data harus diisi!'); // Memberikan peringatan bahwa semua kolom harus diisi
                window.location.href = '../view/tambahPelanggan.php'; // Kembali ke halaman form tambah pelanggan
              </script>";
        exit; // Menghentikan eksekusi lebih lanjut jika ada data yang kosong
    }

    // Query SQL untuk menambahkan data pelanggan ke dalam tabel pelanggan
    // Data pelanggan yang telah diinputkan akan dimasukkan ke dalam kolom-kolom yang sesuai di tabel 'pelanggan'
    $query = "INSERT INTO pelanggan (namaPelanggan, alamat, noTelp) 
              VALUES ('$namaPelanggan', '$alamat', '$noTelp')";

    // Eksekusi query untuk menambahkan data ke dalam database
    if (mysqli_query($db, $query)) {
        // Jika query berhasil dieksekusi, tampilkan pesan sukses
        // dan alihkan pengguna ke halaman daftar pelanggan
        echo "<script>
                alert('Pelanggan berhasil ditambahkan!'); // Pesan sukses ketika data berhasil ditambahkan
                window.location.href = '../view/tampilPelanggan.php'; // Redirect ke halaman tampil pelanggan setelah berhasil
              </script>";
    } else {
        // Jika terjadi kesalahan saat eksekusi query, tampilkan pesan error
        // dan biarkan pengguna tetap berada di halaman form untuk mencoba lagi
        echo "<script>
                alert('Terjadi kesalahan saat menambahkan pelanggan!'); // Pesan error jika gagal menambahkan data
                window.location.href = '../view/tambahPelanggan.php'; // Kembali ke halaman form tambah pelanggan
              </script>";
    }
}
?>
