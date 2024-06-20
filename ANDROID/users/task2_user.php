<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar soal mendengar</title>
    <link rel="stylesheet" href="../css/style-user.css">
</head>
<body>
<header>
<div class="profile">
    <?php
    // Mengaktifkan session pada PHP
    session_start();
    // Menghubungkan PHP dengan koneksi database
    $koneksi = mysqli_connect("localhost","root","","e_learning_jpl");
    // Periksa apakah 'id' ada dalam session sebelum mengaksesnya
    if (isset($_SESSION['id'])) {
        // Query untuk mengambil nama dan level pengguna dari tabel user (asumsi nama tabel adalah "user" dan kolom level adalah "level")
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
                echo "<img src='../uploads_profile/$profile_picture' alt='Profile Picture'>";
            } else {
                // Tampilkan gambar default jika gambar profil tidak tersedia
                echo "<img src='../../images/default_profile_picture.jpg' alt='Profile Picture'>";
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
</header>
<div class="container">
    <div class="carousel-container2">
        <h1>Daftar Soal</h1>
        <div class="carousel-slide" id="carouselSlide">
            <?php
            $id_level_tm = $_GET['id'];
            $query = "SELECT tm.id_level, tm.nama, tm.audio, tm.gambar_benar, tm.gambar_salah1, tm.gambar_salah2, tm.gambar_salah3 
                      FROM task_mendengar as tm 
                      JOIN gambar_mendengar as gm ON tm.id_level = gm.id_level 
                      WHERE tm.id_level = '$id_level_tm'";
            $result = mysqli_query($koneksi, $query);
            if ($result->num_rows > 0) :
                $totalSlides = $result->num_rows; // Total slides
                $currentIndex = 0; // Current slide index
                while($row = $result->fetch_assoc()) :
                    $jawaban = array(
                        $row['gambar_benar'],
                        $row['gambar_salah1'],
                        $row['gambar_salah2'],
                        $row['gambar_salah3']
                    );
                    shuffle($jawaban);
            ?>
            <div class="carousel-item <?php if ($currentIndex === 0) echo 'active'; ?>">
                <div class="card-body">
                    <h2 class="card-title"><?php echo $row['nama']; ?></h2>
                    <audio controls class="audio-task">
                        <source src="../audio/<?php echo $row['audio']; ?>" type="audio/mpeg">
                    </audio>
                    <div class="form-group">
                        <h2>Pilih Jawaban:</h2>
                        <?php foreach ($jawaban as $key => $value) : ?>
                            <div class="form-check">
                                <input class="form-check-input jawaban-radio" type="radio" name="jawaban_<?php echo $row['id_level']; ?>" value="<?php echo $value; ?>" id="jawaban_<?php echo $row['id_level'] . '_' . $key; ?>" data-jawaban-benar="<?php echo $row['gambar_benar']; ?>" required>
                                <label class="form-check-label" for="jawaban_<?php echo $row['id_level'] . '_' . $key; ?>">
                                    <img src="../images/gambar_task/<?php echo $value; ?>" alt="Jawaban" class="img-fluid">
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php
                $currentIndex++;
                endwhile;
            else :
            ?>
            <p>Tidak ada soal tersedia.</p>
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
                    window.location.href = 'task_mendengar.php';
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
        const answers = slide.querySelectorAll('.jawaban-radio');
        answers.forEach(answer => {
            answer.addEventListener('change', (event) => {
                const selectedAnswer = event.target;
                const correctAnswer = selectedAnswer.dataset.jawabanBenar;
                if (selectedAnswer.value === correctAnswer) {
                    alert('Jawaban Anda benar!');
                    setTimeout(() => {
                        moveToNextSlide();
                    }, 500); // Tambahkan jeda waktu sebelum pindah slide
                } else {
                    alert('Jawaban Anda salah, silakan coba lagi.');
                }
            });
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