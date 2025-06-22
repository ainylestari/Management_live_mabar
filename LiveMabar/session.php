<?php
session_start();
if(empty($_SESSION['ID_Penonton']))
{
    header("location:login.php?pesan=belum_login");
}
?>