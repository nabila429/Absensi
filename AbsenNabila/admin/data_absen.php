<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$admin_username = $_SESSION['username'];

$search = "";
$absen_query = "SELECT absen.*, siswa.nama FROM absen INNER JOIN siswa ON absen.nis = siswa.nis ORDER BY absen.tanggal DESC";

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $absen_query = "SELECT absen.*, siswa.nama FROM absen 
        INNER JOIN siswa ON absen.nis = siswa.nis 
        WHERE absen.nis LIKE '%$search%' 
        OR siswa.nama LIKE '%$search%' 
        OR absen.status LIKE '%$search%' 
        OR absen.tanggal LIKE '%$search%'";
}
$absen_result = $conn->query($absen_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Absensi - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    function printTable() {
        const printContent = `
            <div style="text-align: center; font-size: 24px; font-weight: bold; margin-bottom: 20px;">
                Laporan Data Absensi Siswa
            </div>
            <div style="margin-bottom: 20px;">
                <p style="text-align: center; font-size: 18px;">SMK Indonesia</p>
                <p style="text-align: center; font-size: 16px;">Tanggal Cetak: ${new Date().toLocaleDateString()}</p>
            </div>
            ${document.getElementById("absenTable").outerHTML}
        `;
        
        const originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent;
        
        // Additional styling for print
        const printStyle = `
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                th, td {
                    border: 1px solid #ccc;
                    padding: 8px;
                    text-align: center;
                }
                th {
                    background-color: #e0e1dd;
                    color: #0d1b2a;
                }
                td {
                    color: #0d1b2a;
                }
                .status {
                    padding: 5px 10px;
                    border-radius: 5px;
                    color: #fff;
                    font-weight: bold;
                }
                .status.hadir {
                    background-color: green;
                }
                .status.izin {
                    background-color: yellow;
                    color: black;
                }
                .status.tidak_hadir {
                    background-color: red;
                }
            </style>
        `;
        
        document.head.innerHTML += printStyle;
        
        window.print();
        document.body.innerHTML = originalContent;
    }
</script>

</head>
<body class="bg-gray-100 text-gray-800 font-sans">

    <nav class="bg-[#0d1b2a] text-white py-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6">
            <h1 class="text-xl font-bold">SMK INDONESIA</h1>
            <div class="space-x-6 text-base font-medium">
                <a href="dashboard.php" class="hover:text-blue-300">Dashboard</a>
                <a href="data_siswa.php" class="hover:text-blue-300">Data Siswa</a>
                <a href="data_absen.php" class="hover:text-blue-300">Data Absen</a>
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white rounded-xl shadow-lg">

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-[#0d1b2a]">Halo, <?= ucfirst($admin_username); ?>!</h2>
            <p class="text-gray-600">Kelola data absensi siswa dengan mudah.</p>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
            
            <form method="POST" class="flex w-full md:w-2/3 items-center gap-3">
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
                       placeholder="Cari NIS, Nama, Tanggal..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0d1b2a] shadow-sm">
                <button type="submit" class="bg-[#0d1b2a] text-white px-5 py-2 rounded-xl hover:bg-[#1b263b] transition">
                    Cari
                </button>
            </form>

            <a href="data_siswa.php" class="bg-green-600 text-white px-5 py-2 rounded-xl hover:bg-green-700 transition w-full md:w-fit text-center">
                Kelola Data Siswa
            </a>

            <button onclick="printTable()" class="bg-blue-600 text-white px-5 py-2 rounded-xl hover:bg-blue-700 transition w-full md:w-fit">
                Cetak Absen
            </button>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table id="absenTable" class="min-w-full bg-white text-sm text-center">
                <thead class="bg-[#e0e1dd] text-[#0d1b2a]">
                    <tr>
                        <th class="px-4 py-3 border">NIS</th>
                        <th class="px-4 py-3 border">Nama</th>
                        <th class="px-4 py-3 border">Tanggal</th>
                        <th class="px-4 py-3 border">Waktu</th>
                        <th class="px-4 py-3 border">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($absen_result->num_rows > 0): ?>
                        <?php while ($row = $absen_result->fetch_assoc()): ?>
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-4 py-2 border"><?= htmlspecialchars($row['nis']) ?></td>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($row['nama']) ?></td>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($row['tanggal']) ?></td>
                                <td class="px-4 py-2 border"><?= htmlspecialchars($row['waktu']) ?></td>
                                <td class="px-4 py-2 border">
                                    <span class="px-3 py-1 rounded-full text-white text-xs font-semibold
                                        <?= $row['status'] === 'Hadir' ? 'bg-green-500' : ($row['status'] === 'Izin' ? 'bg-yellow-400 text-black' : 'bg-red-500') ?>">
                                        <?= htmlspecialchars($row['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-gray-500">Tidak ada data ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
