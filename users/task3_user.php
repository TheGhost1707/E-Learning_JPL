<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Soal Menulis</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../fonts/icomoon/style.css">
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
        background-color: rgba(0,0,0,0.5);
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
        margin-bottom:10px;
        border-radius: 50%;
    }

    .popup-content h2,h3{
        margin:0;
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
</head>
<body>
<header>
<div class="profile">
    <?php
    // Mengaktifkan session pada PHP
    session_start();
    // Menghubungkan PHP dengan koneksi database
    $koneksi = mysqli_connect("localhost", "root", "", "e_learning_jpl");
    // Periksa apakah 'id' ada dalam session sebelum mengaksesnya
    if (isset($_SESSION['id'])) {
        // Query untuk mengambil nama, level, dan gambar profil pengguna dari tabel user
        $id = $_SESSION['id']; // Mengambil ID pengguna dari session
        $sql = "SELECT nama, progres_level, foto_profile FROM user WHERE id = '$id'";
        $result = mysqli_query($koneksi, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Ambil data nama, level, dan gambar profil
            $row = mysqli_fetch_assoc($result);
            $nama = $row["nama"];
            $progres_level = $row["progres_level"];
            $profile_picture = $row["foto_profile"];

            // Tampilkan gambar profil jika tersedia
            if (!empty($profile_picture)) {
                // Tampilkan gambar dari database dengan menggunakan tag img
                echo "<img src='../uploads_profile/$profile_picture' alt='Profile Picture' onclick='openProfilePopup()' class='profile-pic'>";
            } else {
                // Tampilkan gambar default jika gambar profil tidak tersedia
                echo "<img src='../images/default_profile_picture.jpg' alt='Profile Picture' onclick='openProfilePopup()'>";
            }

            // Output nama dan level
            echo "<div class='profile-info'>";
            echo "<span>$nama</span>";
            echo "<p id='levelText'>$progres_level</p>";

            // Output progress bar
            echo "<div class='progress-bar'>";
            echo "<div class='progress' style='width: $progres_level%;'></div>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "0 results";
        }
        // Script PHP untuk menentukan level
        if (mysqli_num_rows($result) > 0) {
            $exp_points = $progres_level;

            // Lakukan sesuatu dengan nilai exp_points, seperti menentukan level berdasarkan progres
            $levelText = "";
            $levelColor = ""; // Inisialisasi variabel untuk warna level
            if ($exp_points >= 0 && $exp_points < 25) {
                $levelText = 'Beginner';
                $levelColor = '#00ff00'; // Warna hijau untuk level Beginner
            } else if ($exp_points >= 25 && $exp_points < 50) {
                $levelText = 'Master';
                $levelColor = '#ffff00'; // Warna kuning untuk level Master
            } else if ($exp_points >= 50 && $exp_points < 75) {
                $levelText = 'Grandmaster';
                $levelColor = '#0000ff'; // Warna biru untuk level Grandmaster
            } else {
                $levelText = 'Expert';
                $levelColor = '#ff0000'; // Warna merah untuk level Expert
            }

            // Output level yang ditentukan dengan warna khusus
            echo "<script>
                var levelText = document.getElementById('levelText');
                levelText.textContent = '$levelText';
                levelText.style.color = '$levelColor'; // Terapkan warna khusus
            </script>";
        }
    } else {
        // Jika 'id' tidak ada dalam session, tampilkan pesan kesalahan
        echo "Session 'id' not found";
    }
    ?>
</div>

<!-- Pop-up untuk Profil -->
<div id="profile-popup" class="profile-popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closeProfilePopup()">&times;</span>
        <img src="<?php echo (!empty($profile_picture)) ? '../uploads_profile/'.$profile_picture : '../images/default_profile_picture.jpg'; ?>" alt="Profile Picture" style="border:5px solid black">
        <h2 style="color:black;"><?php echo $nama; ?></h2>
        <h3 style="color:black; font-weight:normal;">Level : <?php echo $levelText ?></h3>
    </div>
</div>

<script>
    // Script untuk menampilkan dan menyembunyikan pop-up profil
    function openProfilePopup() {
        var popup = document.getElementById('profile-popup');
        popup.style.display = 'block';
    }

    function closeProfilePopup() {
        var popup = document.getElementById('profile-popup');
        popup.style.display = 'none';
    }
</script>
</header>
<div class="container">
    <div class="carousel-container2">
        <h1>Daftar Soal</h1>
        <div class="carousel-slide" id="carouselSlide">
            <?php
            $id_level_tm = $_GET['id'];
            $query = "SELECT tm.id_level, nama, tm.gambar, jawaban_benar FROM task_penulisan as tm JOIN gambar_menulis as gm ON tm.id_level = gm.id_level WHERE tm.id_level = '$id_level_tm'";
            $result = mysqli_query($koneksi, $query);
            if ($result->num_rows > 0) :
                $totalSlides = $result->num_rows; // Total slides
                $currentIndex = 0; // Current slide index
                while($row = $result->fetch_assoc()) :
            ?>
            <div class="carousel-item <?php if ($currentIndex === 0) echo 'active'; ?>">
                <div class="card-body">
                    <h2 class="card-title"><?php echo $row['nama']; ?></h2>
                    <img src="../images/gambar_task/<?php echo $row['gambar']; ?>" alt="Gambar Task" class="img-fluid">
                    <div class="form-group">
                        <h2>Masukkan Jawaban:</h2>
                        <input type="text" class="form-control jawaban-text" name="jawaban_<?php echo $row['id_level']; ?>" id="jawaban_<?php echo $row['id_level']; ?>" data-jawaban-benar="<?php echo $row['jawaban_benar']; ?>" required>
                        <br>
                        <button type="button" class="btn btn-primary validate-answer" data-jawaban="<?php echo $row['jawaban_benar']; ?>">Submit</button>
                    </div>
                </div>
            </div>
            <?php
                $currentIndex++;
                endwhile;
            else :
            ?>
            <p style="text-align:center; font-size:20px; margin:30px;">Tidak ada soal tersedia.</p>
            <?php endif; ?>
            <?php $koneksi->close(); ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.carousel-item');
    let currentIndex = 0;

    function updateCarousel() {
        slides.forEach((slide, index) => {
            slide.classList.toggle('active', index === currentIndex);
        });
    }

    function moveToNextSlide() {
        if (currentIndex < slides.length - 1) {
            currentIndex++;
            updateCarousel();
        } else {
            // Tambahkan poin saat menyelesaikan semua soal
            fetch('poin_jawaban.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Selamat, Anda telah menyelesaikan semua soal');
                    // Redirect ke halaman lain setelah menyelesaikan soal
                    window.location.href = 'task_menulis_admin.php';
                } else {
                    alert('Gagal memperbarui poin: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memperbarui poin.');
            });
        }
    }

    slides.forEach((slide, index) => {
        const validateButton = slide.querySelector('.validate-answer');
        const answerInput = slide.querySelector('.jawaban-text');

        validateButton.addEventListener('click', () => {
            const correctAnswer = validateButton.dataset.jawaban;
            if (answerInput.value.trim().toLowerCase() === correctAnswer.toLowerCase()) {
                alert('Jawaban Anda benar!');
                setTimeout(() => {
                    moveToNextSlide();
                }, 500); // Tambahkan jeda waktu sebelum pindah slide
            } else {
                alert('Jawaban Anda salah, silakan coba lagi.');
            }
        });
    });

    updateCarousel();
});
</script>
<footer>
    <div class="footer-container">
        <div class="footer-column">
            <h3><img src="../images/icons/about.png" alt="About Us Icon" class="footer-icon"> About Us</h3>
            <p>Aplikasi ini adalah website yang dibuat oleh mahasiswa universitas pakuan dalam memenuhi tugas akhir. Tentu aplikasi ini masih dalam tahap pengembangan, silahkan kirim laporan dan saran jika terjadi bug atau ingin membantu memberikan ide dan konsep buat pengembangannya. Terimakasih</p>
        </div>
        <div class="footer-column">
            <h3><img src="../images/icons/link.png" alt="Quick Links Icon" class="footer-icon"> Quick Links</h3>
            <ul>
                <li><a href="Dashboard_user.php">Halaman Utama</a></li>
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
</footer>
</body>
</html>
