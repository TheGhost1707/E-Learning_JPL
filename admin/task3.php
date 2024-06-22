<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Soal Menulis</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/style-user.css">
</head>
<body>
<header>
<div class="profile">
    <?php
    session_start();
    $koneksi = mysqli_connect("localhost","root","","e_learning_jpl");
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $sql = "SELECT nama, role, foto_profile FROM user WHERE id = '$id'";
        $result = mysqli_query($koneksi, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $nama = $row["nama"];
            $role = $row["role"];
            $profile_picture = $row["foto_profile"];
            if (!empty($profile_picture)) {
                echo "<img src='../uploads_profile/$profile_picture' alt='Profile Picture'>";
            } else {
                echo "<img src='../images/default_profile_picture.jpg' alt='Profile Picture'>";
            }
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
</footer>
</body>
</html>
