<?php
$host = "localhost";
$user = "root";      // Ganti jika username database kamu berbeda
$pass = "";          // Ganti jika ada password untuk MySQL
$db   = "antrean_mlbb"; // Nama database sesuai file .sql yang kamu upload

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>
