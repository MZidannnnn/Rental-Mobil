<?php
session_start();

include '../connection/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$result = $db->query("SELECT * FROM karyawan WHERE username= '$username' AND password= '$password'");

// buat perulangan if
if ($result->num_rows > 0) {

    $_SESSION['login'] = true;
    header('location: ../view/dashboard.php');
}
// var_dump($_POST);
// die;
echo "
        <script>
        alert('Username Dan Password Salah!');
        document.location.href = '../view/login.php';    
        </script>";
