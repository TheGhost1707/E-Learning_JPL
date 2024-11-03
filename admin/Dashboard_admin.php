<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman utama Admin</title>
    <link rel="stylesheet" href="../css/style-user.css">
    <link rel="icon" href="../images/icons/logo-web.png">
    <style>
        .notification {
            padding: 15px;
            border-radius: 5px;
            color: white;
            text-align: center;
            width: 300px;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s, visibility 0.5s;
        }

        .notification.success {
            background-color: #4CAF50;
        }

        .notification.show {
            opacity: 1;
            visibility: visible;
        }

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
    <?php
    // Menangkap pesan notifikasi jika ada
    if (isset($_GET['pesan']) && $_GET['pesan'] == 'sukses') {
        echo "<div class='notification success'>Login berhasil!<h3>Selamat Datang Admin.</h3></div>";
    }
    ?>
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

        <div class="carousel">
            <img class="carousel-image" src="../images/bg_1.jpeg" alt="Image 1">
            <img class="carousel-image" src="../images/bg_2.jpeg" alt="Image 2">
            <img class="carousel-image" src="../images/bg_3.jpeg" alt="Image 3">
            <div class="overlay">
                <div class="text">SELAMAT DATANG <br> DI APLIKASI PEMBELAJARAN BAHASA JEPANG</div>
            </div>
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="#section">Pengenalan Dasar</a></li>
            <li><a href="#section1">Latihan Soal</a></li>
            <li><a href="#section2">Pembelajaran Lanjutan</a></li>
            <?php
            // Menambahkan tombol logout jika pengguna telah login
            if (isset($_SESSION['id'])) {
                echo '<li><a href="logout.php">Logout</a></li>';
            }
            ?>
        </ul>
    </nav>
    <main>
        <section id="section">
            <h2>Pembelajaran Pengenalan Dasar</h2>
            <p>Pada pembelajaran ini, kamu harus mengenali beberapa pelajaran seperti mendengarkan, membaca, maupun penulisan.
                Setelah kamu menguasai pembelajaran dasar ini, kamu dapat mencoba latihan soal untuk mengukur kemampuanmu
            </p>
            <a href="pengenalan_dasar1.php" style="color:black; text-decoration:none;">
                <div class="box-container-flex">
                    <img src="../images/icons/book.png" alt="">
                    <h4>Pengenalan Kotoba</h4>
                </div>
            </a>
            <a href="pengenalan_dasar2.php" style="color:black; text-decoration:none;">
                <div class="box-container-flex">
                    <img src="../images/icons/listening.png" alt="">
                    <h4>Belajar Mendengarkan</h4>
                </div>
            </a>
            <a href="pengenalan_dasar3.php" style="color:black; text-decoration:none;">
                <div class="box-container-flex">
                    <img src="../images/icons/write.png" alt="">
                    <h4>Cara Penulisan</h4>
                </div>
            </a>
        </section>
        <section id="section1">
            <h2>Latihan Soal Pengenalan Dasar</h2>
            <p>Pada pembelajaran ini, kamu harus menyelesaikan beberapa pelajaran seperti mendengarkan, membaca, maupun penulisan.
                Masing-masing pelajaran ada tingkatan levelnya loh, semakin tinggi maka akan semakin susah pelajarannya. Silahkan pilih pelajaran yang menurutmu mudah dan kamu kuasai. ganbarre~
            </p>
            <a href="task_membaca_admin.php" style="color:black; text-decoration:none;">
                <div class="box-container">
                    <img src="../images/icons/book.png" alt="">
                    <h4>Membaca</h4>
                </div>
            </a>
            <a href="task_mendengar_admin.php" style="color:black; text-decoration:none;">
                <div class="box-container">
                    <img src="../images/icons/listening.png" alt="">
                    <h4>Mendengarkan</h4>
                </div>
            </a>
            <a href="task_menulis_admin.php" style="color:black; text-decoration:none;">
                <div class="box-container">
                    <img src="../images/icons/write.png" alt="">
                    <h4>Penulisan</h4>
                </div>
            </a>
        </section>
        <section id="section2">
            <h2>Pembelajaran Lanjutan</h2>
            <p>Pada pembelajaran ini, kamu harus memahami pelajaran lanjutan dari pembelajaran dasar 1. Pelajaran ini seperti
                percakapan atau pembicaraan dengan orang lain. Ada banyak jenis percakapannya silahkan dipelajari melalui video tayangan dan text percakapan, aku yakin kamu cepat bisa !
            </p>
            <a href="task_percakapan_admin.php" style="color:black; text-decoration:none;">
                <div class="box-container">
                    <img src="../images/icons/play.png" alt="">
                    <h4>Video Pembelajaran</h4>
                </div>
            </a>

            <a href="percakapan.php" style="color:black; text-decoration:none;">
                <div class="box-container">
                    <img src="../images/icons/speaking.png" alt="">
                    <h4>Percakapan / Pembicaraan</h4>
                </div>
            </a>
        </section>
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
                    <li><a href="#section">Pengenalan Dasar</a></li>
                    <li><a href="#section1">Latihan Soal</a></li>
                    <li><a href="#section2">Pembelajaran Lanjutan</a></li>
                    <li>
                        <?php
                        // Menambahkan tombol logout jika pengguna telah login
                        if (isset($_SESSION['id'])) {
                            echo '<li><a href="logout.php">Logout</a></li>';
                        }
                        ?>
                    </li>
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
    </footer>

    <script>
        // JavaScript
        let index = 0;
        const images = document.querySelectorAll('.carousel-image');
        const texts = ['Belajar dengan tema permainan yang seru', 'Pembelajaran yang mudah dipahami dan dihafal', 'Mendapatkan ilmu gratis dan praktis']; // Array teks sesuai dengan gambar

        function nextSlide() {
            images[index].style.display = 'none';
            document.querySelector('.overlay .text').textContent = texts[index]; // Mengubah teks sesuai dengan gambar
            index = (index + 1) % images.length;
            images[index].style.display = 'block';
        }

        // Set interval untuk mengubah slide setiap beberapa detik
        setInterval(nextSlide, 5000); // Ubah angka 3000 menjadi durasi yang diinginkan (dalam milidetik)
    </script>

    <script src="script.js"></script>
</body>

</html>