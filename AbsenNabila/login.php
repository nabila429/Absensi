<?php
session_start();
include 'config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM akun WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $akun = $result->fetch_assoc();
        if (password_verify($password, $akun['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $akun['role'];

            if ($akun['role'] == 'siswa') {
                header("Location: siswa/dashboard.php");
                exit;
            } elseif ($akun['role'] == 'admin') {
                header("Location: admin/dashboard.php");
                exit;
            }
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Akun tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a2a3b, #263c55);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .container:hover {
            transform: scale(1.05);
        }
        h2 {
            text-align: center;
            color: #1a2a3b;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }
        input:focus {
            border-color: #1a2a3b;
            outline: none;
        }
        button {
            background-color: #1a2a3b;
            color: white;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #263c55;
        }
        a {
            color: #1a2a3b;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
        a:hover {
            text-decoration: underline;
        }
        .error {
            color: #ff4d4f;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>
            <a href="register.php">Belum punya akun? Daftar</a>
        </form>
    </div>
</body>
</html>
