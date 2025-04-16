<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'siswa') {
    header("Location: login.php");
    exit;
}

$nis = $_SESSION['username'];

// Ambil data siswa
$stmt = $conn->prepare("SELECT * FROM siswa WHERE nis = ?");
$stmt->bind_param("s", $nis);
$stmt->execute();
$siswa = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">
<!-- Navbar -->
<div class="bg-[#0d1b2a] text-white py-4 px-6 flex justify-between items-center">
    <!-- Kiri: Judul -->
    <div class="text-xl font-bold">
        SMK INDONESIA
    </div>

    <!-- Kanan: Menu + Logout -->
    <div class="flex items-center gap-6">
        <a href="dashboard.php" class="hover:text-[#ff6f61] text-lg font-medium">Dashboard</a>
        <a href="absen.php" class="hover:text-[#ff6f61] text-lg font-medium">Absen</a>
        <a href="profile.php" class="hover:text-[#ff6f61] text-lg font-medium">Profil</a>
        <a href="riwayat.php" class="hover:text-[#ff6f61] text-lg font-medium">Riwayat Absen</a>
        <a href="../logout.php" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-md text-white text-sm font-semibold transition duration-300">
            Logout
        </a>
    </div>
</div>
s


    <!-- Dashboard Content -->
    <div class="max-w-7xl mx-auto p-8">

        <!-- Welcome Message -->
        <div class="bg-white p-6 rounded-lg shadow-lg flex items-center space-x-6">
            <img src="../images/smkbg2.png" alt="Welcome Animation" class="w-20 h-30 object-cover"> 
            <div>
                <h3 class="text-2xl font-semibold text-[#0d1b2a]">Halo, <strong><?= htmlspecialchars($siswa['nama']) ?></strong>!</h3>
                <p class="mt-2 text-lg text-gray-600">Selamat datang di Dashboard Absensi</p>
            </div>
        </div>

        <!-- Absen Sekarang Button -->
        <div class="mt-10 text-center">
            <a href="absen.php" class="inline-block bg-[#0d1b2a] text-white py-3 px-6 rounded-lg text-lg hover:bg-[#1b263b] transition duration-300">
                Absen Sekarang
            </a>
        </div>
    </div>

</body>
</html>
