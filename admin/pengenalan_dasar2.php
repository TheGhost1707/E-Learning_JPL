<?php
// Menghubungkan PHP dengan koneksi database
include "koneksi.php";
// Query untuk mengambil data dari tabel pengenalan_dasar2
$sql = "SELECT huruf_jepang, arti_huruf, gambar FROM pengenalan_dasar2";
$result = $koneksi->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengenalan Dasar Admin</title>
    <link rel="stylesheet" href="../css/style-user.css">
    <link rel="icon" href="../images/icons/logo-web.png">
    <style>
        .profile-pic {
            cursor: pointer;
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .profile-popup {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .popup-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 10px;
            text-align: center;
        }

        .popup-content img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        audio {
            display: block;
            margin: 20px;
            width: 140px;
            height: 50px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var notification = document.querySelector('.notification');
            if (notification) {
                notification.classList.add('show');
                setTimeout(function() {
                    notification.classList.remove('show');
                }, 1500); // Notifikasi akan hilang setelah 3 detik
            }
        });
    </script>
</head>

<body>
    <header>
        <div class="profile">
            <?php
            // Mengaktifkan session pada PHP
            session_start();
            // Menghubungkan PHP dengan koneksi database
            include "koneksi.php";
            // Periksa apakah 'id' ada dalam session sebelum mengaksesnya
            if (isset($_SESSION['id'])) {
                // Query untuk mengambil nama dan level pengguna dari tabel user (asumsi nama tabel adalah "user" dan kolom level adalah "level")
                $id = $_SESSION['id']; // Mengambil ID pengguna dari session
                $sql = "SELECT nama, role, foto_profile FROM user WHERE id = '$id'";
                $result = mysqli_query($koneksi, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Ambil data nama, dan gambar profil
                    $row = mysqli_fetch_assoc($result);
                    $nama = $row["nama"];
                    $profile_picture = $row["foto_profile"];
                    $role = $row['role'];

                    // Tampilkan gambar profil jika tersedia
                    if (!empty($profile_picture)) {
                        // Tampilkan gambar dari database dengan menggunakan tag img
                        echo "<img src='../uploads_profile/$profile_picture' alt='Profile Picture' class='profile-pic'>";
                    } else {
                        // Tampilkan gambar default jika gambar profil tidak tersedia
                        echo "<img src='../images/default_profile_picture.jpg' alt='Profile Picture' class='profile-pic'>";
                    }

                    // Output nama dan level
                    echo "<div class='profile-info'>";
                    echo "<span>$nama</span>";
                    echo "<p>($role)</p>";
                    echo "</div>";
                } else {
                    echo "0 results";
                }
            }
            ?>
        </div>
        <div id="profile-popup" class="profile-popup">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <img src="<?php echo (!empty($profile_picture)) ? "../uploads_profile/$profile_picture" : "../images/default_profile_picture.jpg"; ?>" alt="Profile Picture">
                <h2 style="color:black;"><?php echo $nama; ?> (<?php echo $role ?>)</h2>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var profilePic = document.querySelector('.profile-pic');
                var popup = document.getElementById('profile-popup');
                var closeBtn = document.querySelector('.close-btn');

                profilePic.addEventListener('click', function() {
                    popup.style.display = 'block';
                });

                closeBtn.addEventListener('click', function() {
                    popup.style.display = 'none';
                });

                window.addEventListener('click', function(event) {
                    if (event.target == popup) {
                        popup.style.display = 'none';
                    }
                });
            });
        </script>
    </header>
    <main>
        <a href="#" style="color:white; text-decoration:none" id="tambahPembelajaranLink">
            <button class="btn-tambah-lvl">Tambah Pembelajaran</button>
        </a>
        <div id="popup1" class="popup">
            <div class="popup-content">
                <span class="close" id="close1">&times;</span>
                <iframe src="tambah_pengenalan2.php" width="100%" height="400px"></iframe>
            </div>
        </div>
        <div class="title-pembelajaran">
            <h1>Pengenalan suara nama buah</h1>
            <hr>
            <p>Pembelajaran berikut ini memperkenalkan nama-nama buah dalam bahasa Jepang.
                Hafalkan dan pahami setiap nama buah, karena pengetahuan ini akan sangat bermanfaat!
                Dengan menguasai penyebutan buah-buahan dalam bahasa Jepang, kamu semakin siap untuk berbicara layaknya seorang penutur asli.
                Ganbatte!
            </p>
        </div>
        <div class="content-pembelajaran">
            <?php
            include 'koneksi.php';
            // Query untuk mengambil data dari tabel
            $sql = "SELECT*FROM pengenalan_dasar2 where kategori='buah'";
            $result = $koneksi->query($sql);

            // Memeriksa apakah ada data yang tersedia
            if ($result->num_rows > 0) {
                // Loop melalui data dan menampilkan dalam HTML
                while ($row = $result->fetch_assoc()) {
            ?>
                    <a href="#" style="color:black; text-decoration:none;">
                        <div class="box-container">
                            <img src="../images/gambar_task/<?php echo $row['gambar']; ?>" alt="">
                            <audio controls src="../audio/<?php echo $row['audio']; ?>"></audio>
                            <h4><?php echo htmlspecialchars($row['huruf_jepang']); ?></h4>
                            <p style="text-align:center; font-size:18px; font-weight:bold;"><?php echo htmlspecialchars($row['arti_huruf']); ?></p>
                            <a href="#" class="edit_button" id="<?php echo $row['id_pengenalan']; ?>">Edit</a>
                            <a href="delete_pengenalan2.php?id=<?php echo $row['id_pengenalan']; ?>" class="delete_button" onclick="return confirm('Anda yakin ingin menghapus pembelajaran ini?')">Delete</a>

                        </div>
                    </a>
            <?php
                }
            } else {
                echo "<p>Tidak ada data yang tersedia.</p>";
            }
            ?>
        </div>
        <div class="title-pembelajaran">
            <h1>Pengenalan suara nama anggota keluarga</h1>
            <hr>
            <p>Pembelajaran berikut ini memperkenalkan nama-nama keluarga dalam bahasa Jepang.
                Hafalkan dan pahami setiap nama keluarga, karena pengetahuan ini akan sangat bermanfaat!
                Dengan menguasai penyebutan dalam bahasa Jepang, kamu semakin siap untuk berbicara layaknya seorang penutur asli.
                Ganbatte!
            </p>
        </div>
        <div class="content-pembelajaran">
            <?php
            include 'koneksi.php';
            // Query untuk mengambil data dari tabel
            $sql = "SELECT*FROM pengenalan_dasar2 where kategori='keluarga'";
            $result = $koneksi->query($sql);

            // Memeriksa apakah ada data yang tersedia
            if ($result->num_rows > 0) {
                // Loop melalui data dan menampilkan dalam HTML
                while ($row = $result->fetch_assoc()) {
            ?>
                    <a href="#" style="color:black; text-decoration:none;">
                        <div class="box-container">
                            <img src="../images/gambar_task/<?php echo $row['gambar']; ?>" alt="">
                            <audio controls src="../audio/<?php echo $row['audio']; ?>"></audio>
                            <h4><?php echo htmlspecialchars($row['huruf_jepang']); ?></h4>
                            <p style="text-align:center; font-size:18px; font-weight:bold;"><?php echo htmlspecialchars($row['arti_huruf']); ?></p>
                            <a href="#" class="edit_button" id="<?php echo $row['id_pengenalan']; ?>">Edit</a>
                            <a href="delete_pengenalan2.php?id=<?php echo $row['id_pengenalan']; ?>" class="delete_button" onclick="return confirm('Anda yakin ingin menghapus pembelajaran ini?')">Delete</a>
                        </div>
                    </a>
            <?php
                }
            } else {
                echo "<p>Tidak ada data yang tersedia.</p>";
            }
            ?>
        </div>
        <div class="title-pembelajaran">
            <h1>Pengenalan suara nama kendaraan</h1>
            <hr>
            <p>Pembelajaran berikut ini memperkenalkan nama-nama kendaraan dalam bahasa Jepang.
                Hafalkan dan pahami setiap nama kendaraan, karena pengetahuan ini akan sangat bermanfaat!
                Dengan menguasai penyebutan dalam bahasa Jepang, kamu semakin siap untuk berbicara layaknya seorang penutur asli.
                Ganbatte!
            </p>
        </div>
        <div class="content-pembelajaran">
            <?php
            include 'koneksi.php';
            // Query untuk mengambil data dari tabel
            $sql = "SELECT*FROM pengenalan_dasar2 where kategori='kendaraan'";
            $result = $koneksi->query($sql);

            // Memeriksa apakah ada data yang tersedia
            if ($result->num_rows > 0) {
                // Loop melalui data dan menampilkan dalam HTML
                while ($row = $result->fetch_assoc()) {
            ?>
                    <a href="#" style="color:black; text-decoration:none;">
                        <div class="box-container">
                            <img src="../images/gambar_task/<?php echo $row['gambar']; ?>" alt="">
                            <audio controls src="../audio/<?php echo $row['audio']; ?>"></audio>
                            <h4><?php echo htmlspecialchars($row['huruf_jepang']); ?></h4>
                            <p style="text-align:center; font-size:18px; font-weight:bold;"><?php echo htmlspecialchars($row['arti_huruf']); ?></p>
                            <a href="#" class="edit_button" id="<?php echo $row['id_pengenalan']; ?>">Edit</a>
                            <a href="delete_pengenalan2.php?id=<?php echo $row['id_pengenalan']; ?>" class="delete_button" onclick="return confirm('Anda yakin ingin menghapus pembelajaran ini?')">Delete</a>
                        </div>
                    </a>
            <?php
                }
            } else {
                echo "<p>Tidak ada data yang tersedia.</p>";
            }

            ?>
        </div>
        <div class="title-pembelajaran">
            <h1>Pengenalan suara nama hewan</h1>
            <hr>
            <p>Pembelajaran berikut ini memperkenalkan nama-nama hewan dalam bahasa Jepang.
                Hafalkan dan pahami setiap nama hewan, karena pengetahuan ini akan sangat bermanfaat!
                Dengan menguasai penyebutan dalam bahasa Jepang, kamu semakin siap untuk berbicara layaknya seorang penutur asli.
                Ganbatte!
            </p>
        </div>
        <div class="content-pembelajaran">
            <?php
            include 'koneksi.php';
            // Query untuk mengambil data dari tabel
            $sql = "SELECT*FROM pengenalan_dasar2 where kategori='hewan'";
            $result = $koneksi->query($sql);

            // Memeriksa apakah ada data yang tersedia
            if ($result->num_rows > 0) {
                // Loop melalui data dan menampilkan dalam HTML
                while ($row = $result->fetch_assoc()) {
            ?>
                    <a href="#" style="color:black; text-decoration:none;">
                        <div class="box-container">
                            <img src="../images/gambar_task/<?php echo $row['gambar']; ?>" alt="">
                            <audio controls src="../audio/<?php echo $row['audio']; ?>"></audio>
                            <h4><?php echo htmlspecialchars($row['huruf_jepang']); ?></h4>
                            <p style="text-align:center; font-size:18px; font-weight:bold;"><?php echo htmlspecialchars($row['arti_huruf']); ?></p>
                            <a href="#" class="edit_button" id="<?php echo $row['id_pengenalan']; ?>">Edit</a>
                            <a href="delete_pengenalan2.php?id=<?php echo $row['id_pengenalan']; ?>" class="delete_button" onclick="return confirm('Anda yakin ingin menghapus pembelajaran ini?')">Delete</a>
                        </div>
                    </a>
            <?php
                }
            } else {
                echo "<p>Tidak ada data yang tersedia.</p>";
            }

            ?>
        </div>
        <div id="popup2" class="popup">
            <div class="popup-content">
                <span class="close" id="close2">&times;</span>
                <iframe id="editIframe" src="" width="100%" height="400px"></iframe>
            </div>
        </div>
    </main>
    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h3><img src="../images/icons/about.png" alt="About Us Icon" class="footer-icon"> About Us</h3>
                <p>Aplikasi ini adalah website yang dibuat oleh mahasiswa universitas pakuan dalam memenuhi tugas akhir. Tentu aplikasi ini masih dalam tahap pengembangan, silahkan kirim laporan dan saran jika terjadi bug atau ingin membantu memberikan ide dan konsep buat pengembangannya. Terimakasih</p>
            </div>
            <div class="footer-column">
                <h3><img src="../images/icons/link.png" alt="Quick Links Icon" class="footer-icon"> Quick Links</h3>
                <ul>
                    <li><a href="Dashboard_admin.php">Halaman Utama</a></li>
                    <?php
                    // Menambahkan tombol logout jika pengguna telah login
                    if (isset($_SESSION['id'])) {
                        echo '<li><a href="logout.php">Logout</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="footer-column">
                <h3><img src="../images/icons/contact.png" alt="Contact Icon" class="footer-icon"> Contact Admin</h3>
                <p>Email: 085021006@student.unpak.ac.id</p>
                <p>Phone: 085180501629</p>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2024 E-Learning Japanese Language. Games and Learning.
        </div>
        <script>
            // Script untuk pop-up Tambah Level
            var link1 = document.getElementById('tambahPembelajaranLink');
            var popup1 = document.getElementById('popup1');
            var span1 = document.getElementById('close1');

            link1.onclick = function(event) {
                event.preventDefault();
                popup1.style.display = 'block';
            }

            span1.onclick = function() {
                popup1.style.display = 'none';
            }

            window.onclick = function(event) {
                if (event.target == popup1) {
                    popup1.style.display = 'none';
                }
            }
        </script>
        <script>
            // Ambil semua tombol edit
            var editButtons = document.querySelectorAll('.edit_button');
            var popup2 = document.getElementById('popup2');
            var close2 = document.getElementById('close2');
            var editIframe = document.getElementById('editIframe');

            // Tambahkan event listener untuk setiap tombol edit
            editButtons.forEach(function(button) {
                button.onclick = function(event) {
                    event.preventDefault();

                    // Ambil ID dari tombol yang diklik
                    var idPengenalan = button.id;

                    // Setel src iframe dengan URL edit_pengenalan2.php dan tambahkan ID sebagai parameter
                    editIframe.src = 'edit_pengenalan2.php?id=' + idPengenalan;

                    // Tampilkan popup modal
                    popup2.style.display = 'block';
                }
            });

            // Fungsi untuk menutup modal ketika tombol close diklik
            close2.onclick = function() {
                popup2.style.display = 'none';
                editIframe.src = ''; // Kosongkan src untuk menghindari muat ulang ketika modal dibuka lagi
            }

            // Tutup modal ketika klik di luar konten modal
            window.onclick = function(event) {
                if (event.target === popup2) {
                    popup2.style.display = 'none';
                    editIframe.src = ''; // Kosongkan src
                }
            }
        </script>
    </footer>
</body>

</html>