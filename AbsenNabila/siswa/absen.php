<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'siswa') {
    header("Location: login.php");
    exit;
}

$nis = $_SESSION['username'];

$absen_success = "";
$absen_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status'])) {
    $tanggal = date("Y-m-d");
    $waktu = date("H:i:s");
    $status = $_POST['status'];

    $cek = $conn->prepare("SELECT * FROM absen WHERE nis = ? AND tanggal = ?");
    $cek->bind_param("ss", $nis, $tanggal);
    $cek->execute();
    $cek_result = $cek->get_result();

    if ($cek_result->num_rows > 0) {
        $absen_error = "Anda sudah absen hari ini!";
    } else {
        $insert = $conn->prepare("INSERT INTO absen (nis, tanggal, waktu, status) VALUES (?, ?, ?, ?)");
        $insert->bind_param("ssss", $nis, $tanggal, $waktu, $status);
        $insert->execute();
        $absen_success = "Absen berhasil!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Harian</title>
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



    <!-- Absen Form -->
    <div class="max-w-2xl mx-auto p-8">

        <!-- Success or Error Message -->
        <?php if ($absen_success): ?>
            <p class="text-green-500 font-semibold"><?= $absen_success ?></p>
        <?php elseif ($absen_error): ?>
            <p class="text-red-500 font-semibold"><?= $absen_error ?></p>
        <?php endif; ?>

        <!-- Absen Form Content -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-[#0d1b2a] text-center mb-4">Form Absen Hari Ini</h2>
            
            <form method="POST">
                <label for="status" class="block text-lg text-gray-700 mb-2">Status Kehadiran</label>
                <select name="status" id="status" class="w-full p-3 border-2 border-[#0d1b2a] rounded-lg mb-6" required>
                    <option value="">Pilih Status</option>
                    <option value="hadir">Hadir</option>
                    <option value="sakit">Sakit</option>
                    <option value="izin">Izin</option>
                    <option value="alfa">Alfa</option>
                </select>
                <button type="submit" class="w-full bg-[#0d1b2a] text-white py-3 rounded-lg text-lg hover:bg-[#1b263b] transition duration-300">
                    Kirim Absen
                </button>
            </form>
        </div>
    </div>

</body>
</html>
