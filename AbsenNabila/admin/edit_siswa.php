<?php
session_start();
include '../config/koneksi.php';

// Cek login
if (!isset($_SESSION['username'])) {
  header("Location: ../login.php");
  exit();
}

// Cek apakah NIS ada di URL
if (!isset($_GET['nis'])) {
  echo "<script>alert('NIS tidak ditemukan!'); window.location='data_siswa.php';</script>";
  exit();
}

$nis = $_GET['nis'];

// Ambil data siswa berdasarkan NIS
$query = mysqli_query($conn, "SELECT * FROM siswa WHERE nis = '$nis'");
$siswa = mysqli_fetch_assoc($query);

if (!$siswa) {
  echo "<script>alert('Data siswa tidak ditemukan!'); window.location='data_siswa.php';</script>";
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nis_baru = htmlspecialchars($_POST['nis']);
  $nis_lama = $siswa['nis'];
  $nama = htmlspecialchars($_POST['nama']);
  $kelas = htmlspecialchars($_POST['kelas']);
  $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);

  // Cek jika NIS diubah
  if ($nis_baru !== $nis_lama) {
    $cekNis = mysqli_query($conn, "SELECT * FROM akun WHERE username = '$nis_baru'");
    if (mysqli_num_rows($cekNis) > 0) {
      echo "<script>alert('NIS baru sudah digunakan!'); window.history.back();</script>";
      exit();
    }
  }

// Jika upload foto baru
if (!empty($_FILES['foto']['name'])) {
  $namaFile = $_FILES['foto']['name'];
  $tmpName = $_FILES['foto']['tmp_name'];
  $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
  $namaBaru = uniqid() . '.' . $ext;

  $folder = '../assets/img/';
  move_uploaded_file($tmpName, $folder . $namaBaru);
  $foto = $namaBaru; // pakai variabel $foto

  // Hapus foto lama jika ada
  $fotoLama = $siswa['foto'];
  if (!empty($fotoLama) && file_exists($folder . $fotoLama) && $fotoLama !== 'banana-character.png') {
    unlink($folder . $fotoLama);
  }
} else {
  // Kalau tidak upload foto baru, gunakan foto lama
  $foto = $siswa['foto'];
}



  // Update data siswa
  $update_siswa = mysqli_query($conn, "UPDATE siswa SET 
    foto='$foto',
    nis='$nis_baru', 
    nama='$nama', 
    kelas='$kelas', 
    jenis_kelamin='$jenis_kelamin',
    foto='$foto'
    WHERE nis='$nis_lama'");

  // Update akun juga
  $passwordBaru = password_hash($nis_baru, PASSWORD_DEFAULT);
  $update_akun = mysqli_query($conn, "UPDATE akun SET 
    username='$nis_baru', 
    password='$passwordBaru' 
    WHERE username='$nis_lama'");

  if ($update_siswa && $update_akun) {
    echo "<script>alert('Data siswa berhasil diperbarui!'); window.location='data_siswa.php';</script>";
    exit();
  } else {
    echo "<script>alert('Gagal memperbarui data.');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Siswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body style="background-image: url('../assets/img/background.png'); background-size: cover; background-position: center;">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid px-3">
      <a class="navbar-brand" href="#">SMK INDONESIA</a>
    </div>
  </nav>

  <section class="container mt-5 pt-5">
    <div class="row justify-content-center">
      <div class="col-md-8 bg-light p-4 rounded border border-primary shadow">
        <h3 class="fw-bold mb-4">Edit Data Siswa</h3>

        <!-- Tampilkan foto lama -->
        <?php if ($siswa['foto']) : ?>
          <div class="mb-3 text-center">
            <img src="../assets/img/<?= htmlspecialchars($siswa['foto']); ?>" alt="Foto Siswa" class="img-thumbnail" width="150">
          </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label">NIS</label>
            <input type="text" name="nis" class="form-control border border-dark" value="<?= htmlspecialchars($siswa['nis']); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Foto (opsional)</label>
            <input type="file" name="foto" class="form-control border border-dark" accept="image/*">
          </div>
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control border border-dark" value="<?= htmlspecialchars($siswa['nama']); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Kelas</label>
            <input type="text" name="kelas" class="form-control border border-dark" value="<?= htmlspecialchars($siswa['kelas']); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select border border-dark" required>
              <option value="Laki-laki" <?= $siswa['jenis_kelamin'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
              <option value="Perempuan" <?= $siswa['jenis_kelamin'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          <a href="data_siswa.php" class="btn btn-secondary ms-2">Batal</a>
        </form>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
