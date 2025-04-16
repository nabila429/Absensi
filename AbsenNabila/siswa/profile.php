<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'siswa') {
    header("Location: login.php");
    exit;
}

$nis = $_SESSION['username'];

$stmt = $conn->prepare("SELECT * FROM siswa WHERE nis = ?");
$stmt->bind_param("s", $nis);
$stmt->execute();
$siswa = $stmt->get_result()->fetch_assoc();

$update_success = "";
if (isset($_POST['update_profile'])) {
    $new_nama = $_POST['nama'];
    $new_jk = $_POST['jenis_kelamin'];
    $new_kelas = $_POST['kelas'];

    $update = $conn->prepare("UPDATE siswa SET nama = ?, jenis_kelamin = ?, kelas = ? WHERE nis = ?");
    $update->bind_param("ssss", $new_nama, $new_jk, $new_kelas, $nis);
    $update->execute();
    $update_success = "Profil berhasil diperbarui!";

    $stmt->execute();
    $siswa = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<!-- Navbar -->
<div class="bg-[#0d1b2a] text-white py-4 px-6 flex justify-between items-center">
    <div class="text-xl font-bold">
        SMK INDONESIA
    </div>
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

<!-- Container -->
<div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-[#0d1b2a] mb-6 text-center">Profil Siswa</h2>

    <?php if ($update_success): ?>
        <p class="text-green-600 text-center font-medium mb-4"><?= $update_success ?></p>
    <?php endif; ?>

    <div class="text-center mb-5">
        <?php
            $foto = $siswa['foto'] ? $siswa['foto'] : 'default.jpg'; // Gunakan default jika tidak ada foto
        ?>
        <img src="../assets/img/<?= htmlspecialchars($foto); ?>" alt="Foto Siswa"
             class="w-36 h-36 rounded-full mx-auto object-cover border-4 border-gray-300">
    </div>

    <form method="POST" class="space-y-5">
        <div>
            <label class="block text-gray-700 font-medium">Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($siswa['nama']) ?>" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Jenis Kelamin</label>
            <select name="jenis_kelamin" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="Laki-laki" <?= $siswa['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= $siswa['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Kelas</label>
            <input type="text" name="kelas" value="<?= htmlspecialchars($siswa['kelas']) ?>" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="text-center">
            <button type="submit" name="update_profile"
                    class="bg-[#0d1b2a] hover:bg-[#1b263b] text-white px-6 py-2 rounded-lg transition duration-300">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

</body>
</html>
