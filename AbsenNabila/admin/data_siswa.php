<?php
session_start();
include '../config/koneksi.php';


if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$admin_username = $_SESSION['username'];

$siswa_query = "SELECT * FROM siswa";
$siswa_result = $conn->query($siswa_query);

$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $siswa_query = "SELECT * FROM siswa WHERE nama LIKE '%$search%' OR nis LIKE '%$search%'";
    $siswa_result = $conn->query($siswa_query);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>

<body class="bg-gray-100 text-gray-800 font-sans">

    <nav class="bg-[#0d1b2a] text-white py-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6">
            <h1 class="text-xl font-bold">SMK INDONESIA</h1>
            <div class="space-x-6 text-base font-medium">
                <a href="dashboard.php" class="hover:text-blue-300">Dashboard</a>
                <a href="data_siswa.php" class="hover:text-blue-300">Data Siswa</a>
                <a href="data_absen.php" class="hover:text-blue-300">Data Absen</a>
                <a href="../logout.php" class="hover:text-blue-300">Logout</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-[#0d1b2a]">Selamat datang, <?= ucfirst($admin_username); ?>!</h1>
            <p class="text-gray-600 mt-1">Silakan kelola data siswa di bawah ini.</p>
        </div>

        <div class="flex justify-between items-center mb-6">
            
            <form method="POST" class="flex items-center gap-4 w-2/3">
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari siswa..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0d1b2a]">
                <button type="submit" class="bg-[#0d1b2a] text-white px-5 py-2 rounded-xl hover:bg-[#1b263b] transition">
                    Cari
                </button>
            </form>

            <a href="tambah_siswa.php" class="bg-[#0d1b2a] text-white px-5 py-2 rounded-xl hover:bg-[#1b263b] transition">
                Tambah Siswa
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto text-sm text-center border rounded-lg shadow-sm">
                <thead class="bg-gray-100 text-[#0d1b2a]">
                    <tr>
                        <th class="px-4 py-3 border">NIS</th>
                        <th class="px-4 py-3 border">Foto</th>
                        <th class="px-4 py-3 border">Nama</th>
                        <th class="px-4 py-3 border">Jenis Kelamin</th>
                        <th class="px-4 py-3 border">Kelas</th>
                        <th class="px-4 py-3 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $siswa_result->fetch_assoc()): ?>
                        <tr class="hover:bg-blue-50">
                            <td class="px-4 py-2 border"><?= htmlspecialchars($row['nis']) ?></td>
                            <td class="px-4 py-2 border">
    <?php if (!empty($row['foto'])): ?>
        <img src="../assets/img/<?= htmlspecialchars($row['foto']) ?>" alt="Foto Siswa" class="w-16 h-16 object-cover rounded-full mx-auto">
    <?php else: ?>
        <span class="text-gray-400 italic">Tidak ada foto</span>
    <?php endif; ?>
</td>
                            <td class="px-4 py-2 border"><?= htmlspecialchars($row['nama']) ?></td>
                            <td class="px-4 py-2 border"><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                            <td class="px-4 py-2 border"><?= htmlspecialchars($row['kelas']) ?></td>
                            <td class="px-4 py-2 border">
                                <a href="edit_siswa.php?nis=<?= $row['nis'] ?>" class="text-blue-500 hover:text-blue-700">Edit</a>
                                <a href="hapus_siswa.php?nis=<?= $row['nis'] ?>" onclick="return confirm('Yakin ingin menghapus siswa ini?')" class="ml-4 text-red-500 hover:text-red-700">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>

