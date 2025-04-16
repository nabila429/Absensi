<?php
session_start();
include '../config/koneksi.php';


if (!isset($_SESSION['username'])) {
  header("Location: ../login.php");
  exit();
}


if (isset($_GET['nis'])) {
  $nis = $_GET['nis'];

  $query = mysqli_query($conn, "SELECT * FROM siswa WHERE nis = '$nis'");
  $siswa = mysqli_fetch_assoc($query);


    mysqli_query($conn, "DELETE FROM siswa WHERE nis = '$nis'");

    header("Location: data_siswa.php?hapus=berhasil");
    exit();
  } else {
    
    header("Location: data_siswa.php?error=notfound");
    exit();
  }
