<?php
// Menyertakan file untuk memeriksa login dan koneksi ke database
include '../controllers/prosesCekLogin.php';
include '../connection/koneksi.php';

// Periksa apakah form telah disubmit dengan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari form input
    $idPelanggan = $_POST['idPelanggan']; // ID pelanggan (hidden field dari form)
    $namaPelanggan = mysqli_real_escape_string($db, $_POST['namaPelanggan']); // Nama pelanggan
    $alamat = mysqli_real_escape_string($db, $_POST['alamat']); // Alamat pelanggan
    $noTelp = mysqli_real_escape_string($db, $_POST['noTelp']); // Nomor telepon pelanggan

    // Validasi: Pastikan semua data telah diisi
    if (empty($namaPelanggan) || empty($alamat) || empty($noTelp)) {
        // Jika ada data yang kosong, tampilkan pesan kesalahan dan kembali ke halaman edit
        echo "<script>
                alert('Semua data harus diisi!');
                window.location.href = '../view/editPelanggan.php?id=$idPelanggan';
              </script>";
        exit; // Hentikan eksekusi kode
    }

    // Periksa apakah nomor telepon yang dimasukkan sudah digunakan oleh pelanggan lain
    $checkQuery = "SELECT idPelanggan FROM pelanggan WHERE noTelp = '$noTelp' AND idPelanggan != '$idPelanggan'";
    $checkResult = mysqli_query($db, $checkQuery); // Eksekusi query

    // Jika nomor telepon sudah digunakan, tampilkan pesan kesalahan
    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>
                alert('Nomor telepon sudah digunakan, silakan pilih nomor telepon lain!');
                window.location.href = '../view/editPelanggan.php?id=$idPelanggan';
              </script>";
        exit; // Hentikan eksekusi kode
    }

    // Query SQL untuk memperbarui data pelanggan berdasarkan ID
    $query = "UPDATE pelanggan SET 
              namaPelanggan = '$namaPelanggan', 
              alamat = '$alamat', 
              noTelp = '$noTelp' 
              WHERE idPelanggan = '$idPelanggan'";

    // Eksekusi query update
    if (mysqli_query($db, $query)) {
        // Jika update berhasil, tampilkan pesan sukses dan arahkan ke halaman daftar pelanggan
        echo "<script>
                alert('Data pelanggan berhasil diperbarui!');
                window.location.href = '../view/tampilPelanggan.php';
              </script>";
    } else {
        // Jika update gagal, tampilkan pesan kesalahan dan kembali ke halaman edit
        echo "<script>
                alert('Terjadi kesalahan saat memperbarui data pelanggan!');
                window.location.href = '../view/editPelanggan.php?id=$idPelanggan';
              </script>";
    }
}
?>
