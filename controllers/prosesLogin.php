<?php
session_start();

include '../connection/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$result = $db->query("SELECT * FROM karyawan WHERE username= '$username'");

$row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
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
