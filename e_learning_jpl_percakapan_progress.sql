-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jul 2024 pada 17.17
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
-- Database: `e_learning_jpl`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `gambar_membaca`
--

CREATE TABLE `gambar_membaca` (
  `id_level` int(3) NOT NULL,
  `gambar` varchar(30) NOT NULL,
  `level` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gambar_membaca`
--

INSERT INTO `gambar_membaca` (`id_level`, `gambar`, `level`) VALUES
(18, 'AI-gigapixel.jpg', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `gambar_mendengar`
--

CREATE TABLE `gambar_mendengar` (
  `id_level` int(3) NOT NULL,
  `gambar` varchar(30) NOT NULL,
  `level` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gambar_menulis`
--

CREATE TABLE `gambar_menulis` (
  `id_level` int(3) NOT NULL,
  `gambar` varchar(30) NOT NULL,
  `level` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gambar_percakapan`
--

CREATE TABLE `gambar_percakapan` (
  `id` int(2) NOT NULL,
  `jenis_percakapan` varchar(30) NOT NULL,
  `video` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gambar_percakapan`
--

INSERT INTO `gambar_percakapan` (`id`, `jenis_percakapan`, `video`) VALUES
(8, 'Perkenalkan Diri', '66907aa250a01_Perkenalkan Diri.mp4'),
(9, 'Menanyakan Sesuatu', '66907c1997fb4_Menanyakan Sesuatu.mp4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_percakapan`
--

CREATE TABLE `kategori_percakapan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_percakapan`
--

INSERT INTO `kategori_percakapan` (`id`, `nama`) VALUES
(1, 'Perkenalan'),
(2, 'Pertanyaan Anak SD'),
(3, 'Kategori 3'),
(4, 'Perkenalan Opsi 2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `percakapan`
--

CREATE TABLE `percakapan` (
  `id` int(11) NOT NULL,
  `pembuat_pesan` varchar(100) NOT NULL,
  `nama_pesan` text NOT NULL,
  `kapan_dibuat` timestamp NOT NULL DEFAULT current_timestamp(),
  `kategori_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `percakapan`
--

INSERT INTO `percakapan` (`id`, `pembuat_pesan`, `nama_pesan`, `kapan_dibuat`, `kategori_id`) VALUES
(1, 'John', 'Hai, saya John. Senang bertemu dengan Anda!', '2023-03-01 01:00:00', 1),
(2, 'Doe', 'Hai John, saya Doe. Senang bertemu dengan Anda juga!', '2023-03-01 01:05:00', 1),
(3, 'Alice', 'Halo Bob, nama saya Alice. Bagaimana kabar Anda?', '2023-03-02 02:30:00', 1),
(4, 'Bob', 'Halo Alice, saya baik-baik saja. Bagaimana dengan Anda?', '2023-03-02 02:35:00', 1),
(5, 'Anak A', 'Bu, kenapa langit berwarna biru?', '2023-04-01 03:00:00', 2),
(6, 'Guru A', 'Langit berwarna biru karena atmosfer bumi menyebarkan cahaya biru dari matahari lebih banyak daripada warna lainnya.', '2023-04-01 03:05:00', 2),
(7, 'Anak A', 'Pak, kenapa air laut asin?', '2023-04-02 04:00:00', 2),
(8, 'Guru A', 'Air laut asin karena mengandung garam yang berasal dari batuan di daratan yang terlarut dan terbawa ke laut oleh sungai.', '2023-04-02 04:05:00', 2),
(9, 'Anak A', 'Bu, kenapa pohon bisa tumbuh?', '2023-04-03 05:00:00', 2),
(10, 'Guru A', 'Pohon bisa tumbuh karena fotosintesis, yaitu proses di mana tanaman menggunakan sinar matahari untuk membuat makanan dari air dan karbon dioksida.', '2023-04-03 05:05:00', 2),
(11, 'Pengguna X', 'Apa pendapat Anda tentang teknologi terbaru?', '2023-05-01 07:00:00', 3),
(12, 'Pengguna Y', 'Saya pikir teknologi terbaru sangat menarik dan memiliki potensi besar untuk masa depan.', '2023-05-01 07:05:00', 3),
(13, 'Pengguna Z', 'Bagaimana Anda menggunakan teknologi dalam kehidupan sehari-hari?', '2023-05-02 08:00:00', 3),
(14, 'Pengguna W', 'Saya menggunakan teknologi untuk bekerja, belajar, dan hiburan setiap hari.', '2023-05-02 08:05:00', 3),
(15, 'Akbar ', 'Hallo Guys', '2024-07-14 14:51:11', 1),
(16, 'Akbar ', 'Hallo', '2024-07-14 14:51:27', 4),
(17, 'Eko', 'Kenapa Mau Pinjem Uang?', '2024-07-14 14:52:16', 4),
(18, 'Akbar ', 'Engga Mau Nawari Lu Uang 5 jt mau gak?', '2024-07-14 14:52:46', 1),
(19, 'Eko', 'Pertanyaan Bodoh Macam Apa Ini?', '2024-07-14 14:53:49', 2),
(20, 'Akbar ', 'Yaelah Copy Paste GPT DOANG', '2024-07-14 14:54:56', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_membaca`
--

CREATE TABLE `task_membaca` (
  `id_level` int(3) NOT NULL,
  `id_task` int(3) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `gambar` varchar(30) NOT NULL,
  `jawaban_benar` varchar(30) NOT NULL,
  `jawaban_salah1` varchar(30) NOT NULL,
  `jawaban_salah2` varchar(30) NOT NULL,
  `jawaban_salah3` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_mendengar`
--

CREATE TABLE `task_mendengar` (
  `id_level` int(3) NOT NULL,
  `id_task` int(3) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `audio` varchar(30) NOT NULL,
  `gambar_benar` varchar(30) NOT NULL,
  `gambar_salah1` varchar(30) NOT NULL,
  `gambar_salah2` varchar(30) NOT NULL,
  `gambar_salah3` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_penulisan`
--

CREATE TABLE `task_penulisan` (
  `id_level` int(3) NOT NULL,
  `id_task` int(3) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `gambar` varchar(30) NOT NULL,
  `jawaban_benar` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(3) NOT NULL,
  `foto_profile` varchar(30) NOT NULL,
  `nama` char(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(10) NOT NULL,
  `progres_level` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `foto_profile`, `nama`, `username`, `password`, `role`, `progres_level`) VALUES
(8, '665b8919bb518_DSCF0902.JPG', 'Syaqilla', 'Qilla', '123', 'Users', '35'),
(10, '665b8f47d52eb_kaneki.jpg', 'Akbar Maulana', 'Akbar', '123', 'Admin', '60');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `gambar_membaca`
--
ALTER TABLE `gambar_membaca`
  ADD PRIMARY KEY (`id_level`);

--
-- Indeks untuk tabel `gambar_mendengar`
--
ALTER TABLE `gambar_mendengar`
  ADD PRIMARY KEY (`id_level`);

--
-- Indeks untuk tabel `gambar_menulis`
--
ALTER TABLE `gambar_menulis`
  ADD PRIMARY KEY (`id_level`);

--
-- Indeks untuk tabel `gambar_percakapan`
--
ALTER TABLE `gambar_percakapan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori_percakapan`
--
ALTER TABLE `kategori_percakapan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `percakapan`
--
ALTER TABLE `percakapan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indeks untuk tabel `task_membaca`
--
ALTER TABLE `task_membaca`
  ADD PRIMARY KEY (`id_task`);

--
-- Indeks untuk tabel `task_mendengar`
--
ALTER TABLE `task_mendengar`
  ADD PRIMARY KEY (`id_task`);

--
-- Indeks untuk tabel `task_penulisan`
--
ALTER TABLE `task_penulisan`
  ADD PRIMARY KEY (`id_task`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `gambar_membaca`
--
ALTER TABLE `gambar_membaca`
  MODIFY `id_level` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `gambar_mendengar`
--
ALTER TABLE `gambar_mendengar`
  MODIFY `id_level` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `gambar_menulis`
--
ALTER TABLE `gambar_menulis`
  MODIFY `id_level` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `gambar_percakapan`
--
ALTER TABLE `gambar_percakapan`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `kategori_percakapan`
--
ALTER TABLE `kategori_percakapan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `percakapan`
--
ALTER TABLE `percakapan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `task_membaca`
--
ALTER TABLE `task_membaca`
  MODIFY `id_task` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `task_mendengar`
--
ALTER TABLE `task_mendengar`
  MODIFY `id_task` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `task_penulisan`
--
ALTER TABLE `task_penulisan`
  MODIFY `id_task` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `percakapan`
--
ALTER TABLE `percakapan`
  ADD CONSTRAINT `percakapan_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_percakapan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
