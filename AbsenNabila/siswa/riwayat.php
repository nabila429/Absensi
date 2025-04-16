<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'siswa') {
    header("Location: login.php");
    exit;
}

$nis = $_SESSION['username'];

$riwayat = $conn->prepare("SELECT * FROM absen WHERE nis = ? ORDER BY tanggal DESC");
$riwayat->bind_param("s", $nis);
$riwayat->execute();
$riwayat_result = $riwayat->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Absen</title>
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



    <!-- Riwayat Absen Content -->
    <div class="max-w-4xl mx-auto p-8">

        <h2 class="text-3xl font-semibold text-[#0d1b2a] mb-6">Riwayat Absen</h2>

        <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-[#0d1b2a] text-white">
                    <th class="py-3 px-6 text-left">Tanggal</th>
                    <th class="py-3 px-6 text-left">Waktu</th>
                    <th class="py-3 px-6 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($riwayat_result->num_rows > 0): ?>
                    <?php while ($row = $riwayat_result->fetch_assoc()): ?>
                        <tr class="border-b border-[#ddd] hover:bg-[#f1f1f1]">
                            <td class="py-4 px-6"><?= htmlspecialchars($row['tanggal']) ?></td>
                            <td class="py-4 px-6"><?= htmlspecialchars($row['waktu']) ?></td>
                            <td class="py-4 px-6"><?= htmlspecialchars($row['status']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="3" class="py-4 px-6 text-center text-gray-500">Belum ada data absen.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
