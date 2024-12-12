<?php
// Include file koneksi dan cek login
include '../connection/koneksi.php';
include '../controllers/prosesCekLogin.php';

// Periksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $namaKaryawan = mysqli_real_escape_string($db, $_POST['namaKaryawan']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $noTelp = mysqli_real_escape_string($db, $_POST['noTelp']);
    $alamat = mysqli_real_escape_string($db, $_POST['alamat']);

    // Validasi data
    if (empty($namaKaryawan) || empty($username) || empty($password) || empty($noTelp) || empty($alamat)) {
        echo "<script>
                alert('Semua data harus diisi!');
                window.location.href = '../view/tambahKaryawan.php';
              </script>";
        exit;
    }

    // Periksa apakah username sudah digunakan
    $checkQuery = "SELECT idKaryawan FROM karyawan WHERE username = '$username'";
    $checkResult = mysqli_query($db, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>
                alert('Username sudah digunakan, silakan pilih username lain!');
                window.location.href = '../view/tambahKaryawan.php';
              </script>";
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk menambahkan data ke tabel karyawan
    $query = "INSERT INTO karyawan (namaKaryawan, username, password, noTelp, alamat) 
              VALUES ('$namaKaryawan', '$username', '$hashedPassword', '$noTelp', '$alamat')";

    // Eksekusi query
//      var_dump($_POST);
// die;
    if (mysqli_query($db, $query)) {
        echo "<script>
                alert('Karyawan berhasil ditambahkan!');
                window.location.href = '../view/tampilKaryawan.php';
              </script>";
    } else {
        echo "<script>
       
                alert('Terjadi kesalahan saat menambahkan karyawan!');
                window.location.href = '../view/tambahKaryawan.php';
              </script>";
    }
}
?>
