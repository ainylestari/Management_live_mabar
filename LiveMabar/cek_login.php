<?php
session_start();
include 'config.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$query = "SELECT * FROM penonton WHERE username = '$username' LIMIT 1";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($data) {
    if ($password == $data['password']) { 
        $_SESSION['login'] = true;
        $_SESSION['ID_Penonton'] = $data['ID_Penonton'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['nickname'] = $data['nickname'];

        // Tambahan update nickname di akun_game jika kosong
        $id_penonton = $data['ID_Penonton'];
        $nickname_check_query = "SELECT nickname FROM akun_game WHERE ID_Penonton = '$id_penonton' LIMIT 1";
        $nickname_check_result = mysqli_query($conn, $nickname_check_query);
        $nickname_data = mysqli_fetch_assoc($nickname_check_result);

        if ($nickname_data && (is_null($nickname_data['nickname']) || $nickname_data['nickname'] == '')) {
            $username_to_set = mysqli_real_escape_string($conn, $data['username']);
            mysqli_query($conn, "UPDATE akun_game SET nickname = '$username_to_set' WHERE ID_Penonton = '$id_penonton'");
        }

        header("Location: akun.php"); 
        exit;
    } else {
        echo "<script>alert('Password salah'); window.location='login.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Username tidak ditemukan'); window.location='login.php';</script>";
    exit;
}
?>
