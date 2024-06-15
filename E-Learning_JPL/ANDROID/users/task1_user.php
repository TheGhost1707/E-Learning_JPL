<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Carousel Header</title>
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
            // Menghubungkan PHP dengan koneksi database
            $koneksi = mysqli_connect("localhost", "root", "", "e_learning_jpl");

            // Mengecek koneksi
            if (!$koneksi) {
                die("Koneksi gagal: " . mysqli_connect_error());
            }

            // Query untuk mengambil data soal dari database
            $id_level_tm = $_GET['id'];
            $query = "SELECT tm.id_level, nama, tm.gambar, jenis_task, jawaban_benar, jawaban_salah1, jawaban_salah2, jawaban_salah3 FROM task_membaca as tm JOIN gambar_membaca as gm ON tm.id_level = gm.id_level WHERE tm.id_level = '$id_level_tm'";
            $result = mysqli_query($koneksi, $query);
            // var_dump($id_level_tm);die;

            if ($result->num_rows > 0) :
                while($row = $result->fetch_assoc()) :
                    $jawaban = array(
                        $row['jawaban_benar'],
                        $row['jawaban_salah1'],
                        $row['jawaban_salah2'],
                        $row['jawaban_salah3']
                    );
                    shuffle($jawaban);
            ?>
            <div class="carousel-item">
                <div class="card-body">
                    <h2 class="card-title"><?php echo $row['nama']; ?></h2>
                    <img src="../images/gambar_task/<?php echo $row['gambar']; ?>" alt="Gambar Task" class="img-fluid">
                    <form method="POST" action="cek_jawaban.php">
                        <div class="form-group">
                            <h2>Pilih Jawaban:</h2>
                            <?php foreach ($jawaban as $key => $value) : ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jawaban" value="<?php echo $value; ?>" id="jawaban_<?php echo $row['id_level'] . '_' . $key; ?>">
                                    <label class="form-check-label" for="jawaban_<?php echo $row['id_level'] . '_' . $key; ?>">
                                        <?php echo $value; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" name="id_soal" value="<?php echo $row['id_level']; ?>">
                        <button type="submit" class="btn-submit">Submit</button>
                    </form>
                </div>
            </div>
            <?php endwhile; else : ?>
            <p>Tidak ada soal tersedia.</p>
            <?php endif; ?>
            <?php $koneksi->close(); ?>
        </div>

        <div class="carousel-controls">
            <button class="carousel-button" id="prevButton">Previous</button>
            <button class="carousel-button" id="nextButton">Next</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const slide = document.getElementById('carouselSlide');
    const slides = document.querySelectorAll('.carousel-item');
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');
    let currentIndex = 0;

    function updateCarousel() {
        slides.forEach((slide, index) => {
            slide.classList.toggle('active', index === currentIndex);
        });

        prevButton.disabled = currentIndex === 0;
        nextButton.disabled = currentIndex === slides.length - 1 || !isAnswered();
    }

    function isAnswered() {
        const currentSlide = slides[currentIndex];
        const answers = currentSlide.querySelectorAll('input[name="jawaban"]');
        return Array.from(answers).some(answer => answer.checked);
    }

    prevButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });

    nextButton.addEventListener('click', () => {
        if (currentIndex < slides.length - 1 && isAnswered()) {
            currentIndex++;
            updateCarousel();
        }
    });

    slides.forEach((slide, index) => {
        const answers = slide.querySelectorAll('input[name="jawaban"]');
        answers.forEach(answer => {
            answer.addEventListener('change', () => {
                if (index === currentIndex) {
                    updateCarousel();
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
                <li><a href="#section1">Huruf Jepang</a></li>
                <li><a href="#section2">Pembelajaran 1</a></li>
                <li><a href="#section3">Pembelajaran 2</a></li>
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