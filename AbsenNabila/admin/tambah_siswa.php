<?php
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $kelas = $_POST['kelas'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis'");
    $cekAkun = mysqli_query($conn, "SELECT * FROM akun WHERE username='$nis'");

    if (mysqli_num_rows($cek) > 0 || mysqli_num_rows($cekAkun) > 0) {
        echo "<script>alert('NIS sudah terdaftar!');</script>";
    } else {
        $nama_file = $_FILES['foto']['name'];
        $tmp_file = $_FILES['foto']['tmp_name'];
        $folder = "../assets/img/";  // Folder untuk menyimpan foto
        $ext = pathinfo($nama_file, PATHINFO_EXTENSION);
        $nama_baru = uniqid() . "." . $ext;
        $upload_path = $folder . $nama_baru;

        if (move_uploaded_file($tmp_file, $upload_path)) {
            $insertSiswa = mysqli_query($conn, "INSERT INTO siswa (nama, nis, foto, jenis_kelamin, kelas) VALUES ('$nama', '$nis', '$nama_baru', '$jenis_kelamin', '$kelas')");
            $insertAkun = mysqli_query($conn, "INSERT INTO akun (username, password, role) VALUES ('$nis', '$password', 'siswa')");

            if ($insertSiswa && $insertAkun) {
                echo "<script>alert('Pendaftaran berhasil!'); window.location='data_siswa.php';</script>";
            } else {
                echo "<script>alert('Pendaftaran gagal!');</script>";
            }
        } else {
            echo "<script>alert('Upload foto gagal!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar - Absen</title>
    <link rel="icon" href="assets/img/logo.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f4f6f9;
        }

        .navbar {
            background-color: #0d1b2a;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .card-body {
            background-color: #ffffff;
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #0d1b2a;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
        }

        .btn {
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #0d1b2a;
            border-color: #0d6efd;
        }

        .btn-primary:hover {
            background-color: #0d1b2a;
            border-color: #0a58ca;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid px-3">
        <a class="navbar-brand d-flex align-items-center" href="#">
            SMK INDONESIA
        </a>
    </div>
</nav>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="text-center mb-4 text-primary">Tambah Akun Siswa</h3>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS / Nomor Induk Siswa</label>
                            <input type="text" class="form-control" id="nis" name="nis" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Siswa</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option selected disabled>Pilih jenis kelamin</option>
                                <option value="Laki - Laki">Laki - Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </div>
                        <div class="d-grid gap-2 mt-2">
                            <a href="data_siswa.php" class="btn btn-danger">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
