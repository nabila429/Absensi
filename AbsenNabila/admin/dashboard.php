<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$admin_username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        .navbar {
            background-color: #0d1b2a;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 8px;
            font-weight: 500;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .navbar a:hover {
            color: #90e0ef;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 15px;
        }

        h2 {
            text-align: center;
            color: #0d1b2a;
            font-size: 20px;
            margin-bottom: 25px;
        }

        .welcome {
            background: linear-gradient(to right, #caf0f8, #ade8f4);
            border-left: 5px solid #0077b6;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .welcome h3 {
            margin: 0 0 5px;
            color: #0077b6;
            font-size: 16px;
        }

        .welcome p {
            margin: 0;
            color: #333;
            font-size: 13px;
        }

        .welcome img {
            width: 150px;
            height: 150px;
            animation: float 2s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }

        .card {
            background-color: white;
            padding: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        .card h3 {
            margin: 0;
            color: #1b263b;
            font-size: 16px;
        }

        .kelola-btn {
            background-color:#1b263b;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            transition: background 0.3s ease;
            text-decoration: none;
        }

        .kelola-btn:hover {
            background-color: #1b263b;
        }

        .logout-btn {
            background-color: #d9534f;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #c9302c;
        }

        @media (max-width: 600px) {
            .navbar {
                flex-direction: column;
                text-align: center;
            }

            .card {
                flex-direction: column;
                align-items: flex-start;
            }

            .kelola-btn {
                margin-top: 10px;
                width: 100%;
                text-align: center;
            }

            .welcome {
                flex-direction: column;
                align-items: flex-start;
            }

            .welcome img {
                align-self: center;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo-title" style="font-size: 18px; font-weight: bold;">
        SMK INDONESIA
    </div>
    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="data_siswa.php">Data Siswa</a>
        <a href="data_absen.php">Data Absen</a>
        <a href="../logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Selamat Datang, <?= htmlspecialchars($admin_username) ?>!</h2>

    <div class="welcome">
        <div>
            <h3>Hai Admin!</h3>
            <p>Kelola data siswa dan absen dengan mudah melalui dashboard ini. Semangat bekerja ya!</p>
        </div>
        <img src="../images/smkbg.png" alt="Welcome">
    </div>

    <div class="card">
        <h3>Data Siswa</h3>
        <a href="data_siswa.php" class="kelola-btn">Kelola</a>
    </div>

    <div class="card">
        <h3>Data Absen</h3>
        <a href="data_absen.php" class="kelola-btn">Kelola</a>
    </div>
</div>

</body>
</html>
