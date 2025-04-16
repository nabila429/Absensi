-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Apr 2025 pada 12.45
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_siswa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absen`
--

CREATE TABLE `absen` (
  `id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `status` enum('hadir','sakit','izin','alfa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absen`
--

INSERT INTO `absen` (`id`, `nis`, `tanggal`, `waktu`, `status`) VALUES
(2, '12233842', '2025-04-13', '12:21:49', 'hadir'),
(3, '45503', '2025-04-14', '04:27:57', 'sakit'),
(4, '200406', '2025-04-14', '05:38:46', 'hadir'),
(5, '23365', '2025-04-14', '12:43:05', 'izin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','siswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`id`, `username`, `password`, `role`) VALUES
(1, 'nabila', '$2y$10$3fouDQpeaEtBppNDlUaXiuUWNdnVefzelhl3VhRyZSruDYCbKS1ou', 'admin'),
(2, '12233842', '$2y$10$oX7cdxAz6qlpascrOVuybe1PKmrT5.Rt3cHIdI0oUEmpi8HSkGQ6S', 'siswa'),
(3, '201206', '$2y$10$XiSt7gKkUdFTcp0g/GjRUOnWAexM7UG78HWjT2Cp8rbe9xXd8Oima', 'siswa'),
(4, '45503', '$2y$10$m9NN.u3du3a0UbFW6DMxGOnURm.l7Gch5F7bnfANU9O11lFskANDW', 'siswa'),
(7, '20120666', '$2y$10$vqm8rloERAsljZaMH6BmQOdHEAc4TQFY/uUPPHgvdrwi1Qv/1g8ju', 'siswa'),
(8, '100908', '$2y$10$RTWsCXW5nEvsZAE5nhEjueYJWf6EVq8tm.B.KsCLNuBwONjaXPTyO', 'siswa'),
(9, '45555', '$2y$10$ZYm4JK3EZLem6tuECiPPf.dQtmwORgyw48ClElWvQIs6oRePEuBH6', 'siswa'),
(10, '6555', '$2y$10$LQSVk7X3L3oP49RhpojB5uKrvNBv1t05aub8X4EJp8iRVAd6aD1Ia', 'siswa'),
(11, '111', '$2y$10$ekOIMo5QhmpRLzNO.Zow6eBrpiEQUnHSL5YzJ6mPW1xxbo1IHQG46', 'siswa'),
(12, '1117', '$2y$10$ShUDbbDJiZREuOZxSaV8vufHBxW1FhnQovBLqtmA2qxceF1mhB3g2', 'siswa'),
(13, '200406', '$2y$10$1bp99aBsOJ8JCy1gd6jJA.EzdovuCqlqjW3Mg45EjQDy1y7axiO5.', 'siswa'),
(14, '7777', '$2y$10$0bSMeD1IKMuOMY2ZxOZ6Suv3D2pwpOz5Rxta08WDniNs9h/HWoG6a', 'siswa'),
(16, '888', '$2y$10$H8DalvSpNmYqaLGfOnwLb.WivBF86VEOKYmDuWEVHKzsl14Pw5Saa', 'siswa'),
(17, '99', '$2y$10$ylZqQ.3hlNNEVpFNBSTIYOyYYz8FnhLq.cDO5lhHV1dGLlVfxbQUO', 'siswa'),
(18, '12354', '$2y$10$0hJpf7wwfMiCUtG2ia5DGeeLlV3FwsUz/2iYLioklzZVmwLqyOZsy', 'siswa'),
(19, '21212', '$2y$10$gag1Gd./HMnwRT1lTrcZzOMAQ3IMImq43Z1NgDe/9MCApDHXRIO3K', 'siswa'),
(20, '23345', '$2y$10$jDqyNl8TFspqtn..GbWBTef7XxQ4/FvOWX3vydgKl8tv06Ih/pNdu', 'siswa'),
(21, '23365', '$2y$10$eLY6bu/ZNti/LZ1BM4hNaesM/7MwNfTQfUnqwF.SUlRFhzbvTKM7a', 'siswa'),
(22, '23376', '$2y$10$ItsR9R4Rk8Ws4bDvOVRU7.Azg6X0igRlyytIjZbfSxZEUmzv8pJAG', 'siswa'),
(23, '23387', '$2y$10$DVV1rTOiTgqrhJm9iIGcFuAsKxyFD5ytMwG2FDquohAZxHYrcc2g.', 'siswa'),
(24, '23343', '$2y$10$rZxCMZwKCwg8gKJZa8aE/uXAhsOMJA2JKyjRU5jI6uLsN6OTAJQ/O', 'siswa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `kelas` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `foto`, `nama`, `nis`, `jenis_kelamin`, `kelas`) VALUES
(1, '67fce66c4602a.jpeg', 'Fatima Azzahra', '12233842', 'Perempuan', 'XII PPLG A'),
(3, '67fce65cb4f97.jpeg', 'Yusrina', '45503', 'Perempuan', 'XII PPLG A'),
(4, '67fce22cb7262.jpg', 'Nabila Shalsabila', '20120666', 'Perempuan', 'XII PPLG A'),
(10, '67fce64f97c98.jpeg', 'Melisa Aprilia', '200406', 'Perempuan', 'XII TKJ A'),
(14, '67fcbc54581744.64794807.jpeg', 'nabilaaaa', '12354', 'Perempuan', 'XII PPLG A'),
(16, '67fce4d23e66d.jpeg', 'Atala Alif', '23345', 'Laki-laki', 'XII PPLG A'),
(17, '67fce51db9fbd.jpeg', 'Prita Putri', '23365', 'Perempuan', 'XII PPLG A'),
(18, '67fce57892f7c.jpeg', 'Azka Putra N', '23376', 'Perempuan', 'XII PPLG A'),
(19, '67fce6143cb5f.jpeg', 'Falta Azahra', '23387', 'Perempuan', 'XII PPLG A'),
(20, '67fce63e8daf2.jpeg', 'Atalia Prataya', '23343', 'Perempuan', 'XII PPLG A');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nis` (`nis`);

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nis` (`nis`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absen`
--
ALTER TABLE `absen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absen`
--
ALTER TABLE `absen`
  ADD CONSTRAINT `absen_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
