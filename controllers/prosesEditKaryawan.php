<?php
include '../controllers/prosesCekLogin.php';
include '../connection/koneksi.php';

// Periksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idKaryawan = $_POST['idKaryawan'];
    $namaKaryawan = mysqli_real_escape_string($db, $_POST['namaKaryawan']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = $_POST['password'];
    $noTelp = mysqli_real_escape_string($db, $_POST['noTelp']);
    $alamat = mysqli_real_escape_string($db, $_POST['alamat']);

    // Validasi data
    if (empty($namaKaryawan) || empty($username) || empty($noTelp) || empty($alamat)) {
        echo "<script>
                alert('Semua data kecuali password harus diisi!');
                window.location.href = '../view/editKaryawan.php?id=$idKaryawan';
              </script>";
        exit;
    }

    // Periksa apakah username sudah digunakan oleh karyawan lain
    $checkQuery = "SELECT idKaryawan FROM karyawan WHERE username = '$username' AND idKaryawan != '$idKaryawan'";
    $checkResult = mysqli_query($db, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>
                alert('Username sudah digunakan, silakan pilih username lain!');
                window.location.href = '../view/editKaryawan.php?id=$idKaryawan';
              </script>";
        exit;
    }

    // Update data karyawan
    if (!empty($password)) {
        // Jika password diisi, hash dan update
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE karyawan SET 
                  namaKaryawan = '$namaKaryawan', 
                  username = '$username', 
                  password = '$hashedPassword', 
                  noTelp = '$noTelp', 
                  alamat = '$alamat' 
                  WHERE idKaryawan = '$idKaryawan'";
    } else {
        // Jika password tidak diisi, jangan ubah password
        $query = "UPDATE karyawan SET 
                  namaKaryawan = '$namaKaryawan', 
                  username = '$username', 
                  noTelp = '$noTelp', 
                  alamat = '$alamat' 
                  WHERE idKaryawan = '$idKaryawan'";
    }

    // Eksekusi query
    if (mysqli_query($db, $query)) {
        echo "<script>
                alert('Data karyawan berhasil diperbarui!');
                window.location.href = '../view/tampilKaryawan.php';
              </script>";
    } else {
        echo "<script>
                alert('Terjadi kesalahan saat memperbarui data karyawan!');
                window.location.href = '../view/editKaryawan.php?id=$idKaryawan';
              </script>";
    }
}
?>
