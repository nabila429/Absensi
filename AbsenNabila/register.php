<?php
include 'config/koneksi.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $nis = $_POST["nis"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $kelas = $_POST["kelas"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // File upload handling
    $foto = $_FILES['foto'];
    $foto_name = $foto['name'];
    $foto_tmp = $foto['tmp_name'];
    $foto_error = $foto['error'];
    $foto_size = $foto['size'];

    // Check if the file is an image and its size
    if ($foto_error === 0) {
        $file_ext = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($file_ext, $allowed_exts)) {
            // Check file size (5MB max)
            if ($foto_size < 5000000) {
                // Generate unique file name to prevent conflicts
                $foto_new_name = uniqid('', true) . '.' . $file_ext;
                $foto_destination = 'assets/img/' . $foto_new_name;

                if (move_uploaded_file($foto_tmp, $foto_destination)) {
                    // Check if NIS already exists
                    $cek = $conn->prepare("SELECT * FROM siswa WHERE nis = ?");
                    $cek->bind_param("s", $nis);
                    $cek->execute();
                    $result = $cek->get_result();

                    if ($result->num_rows > 0) {
                        $error = "NIS sudah terdaftar!";
                    } else {
                        // Insert new student data into the database
                        $stmt1 = $conn->prepare("INSERT INTO siswa (nama, nis, jenis_kelamin, kelas, foto) VALUES (?, ?, ?, ?, ?)");
                        $stmt1->bind_param("sssss", $nama, $nis, $jenis_kelamin, $kelas, $foto_new_name);
                        $stmt1->execute();

                        // Insert account data
                        $stmt2 = $conn->prepare("INSERT INTO akun (username, password, role) VALUES (?, ?, 'siswa')");
                        $stmt2->bind_param("ss", $nis, $password);
                        $stmt2->execute();

                        $success = "Registrasi berhasil! Silakan login.";
                    }
                } else {
                    $error = "Gagal mengunggah foto!";
                }
            } else {
                $error = "Ukuran foto terlalu besar! Maksimal 5MB.";
            }
        } else {
            $error = "Tipe file foto tidak valid! Harap unggah file JPG, JPEG, PNG, atau GIF.";
        }
    } else {
        $error = "Terjadi kesalahan saat mengunggah foto.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-center text-[#0d1b2a] mb-6">Daftar Akun</h2>

        <?php if ($success) echo "<div class='text-green-500 text-center mb-4'>$success</div>"; ?>
        <?php if ($error) echo "<div class='text-red-500 text-center mb-4'>$error</div>"; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-6">

            <div>
                <label for="nama" class="block text-lg font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0d1b2a]" placeholder="Masukkan nama lengkap">
            </div>

            <div>
                <label for="nis" class="block text-lg font-medium text-gray-700">NIS</label>
                <input type="text" name="nis" id="nis" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0d1b2a]" placeholder="Masukkan NIS">
            </div>

            <div>
                <label for="jenis_kelamin" class="block text-lg font-medium text-gray-700">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0d1b2a]">
                    <option value="">Pilih</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div>
                <label for="kelas" class="block text-lg font-medium text-gray-700">Kelas</label>
                <input type="text" name="kelas" id="kelas" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0d1b2a]" placeholder="Masukkan kelas">
            </div>

            <div>
                <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0d1b2a]" placeholder="Masukkan password">
            </div>

            <div>
                <label for="foto" class="block text-lg font-medium text-gray-700">Foto Profil</label>
                <input type="file" name="foto" id="foto" accept="image/*" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0d1b2a]">
            </div>

            <button type="submit" class="w-full py-3 mt-4 bg-[#0d1b2a] text-white text-lg font-semibold rounded-lg hover:bg-[#1b263b] transition duration-300">Daftar</button>
        </form>

        <p class="text-center mt-4 text-sm text-gray-600">Sudah punya akun? <a href="login.php" class="text-[#0d1b2a] font-medium hover:text-[#1b263b]">Login</a></p>
    </div>

</body>
</html>
