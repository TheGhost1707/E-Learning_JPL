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
                echo "<img src='../images/default_profile_picture.jpg' alt='Profile Picture'>";
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
            <li><a href="#section1">Huruf Jepang</a></li>
            <li><a href="#section2">Pembelajaran 1</a></li>
            <li><a href="#section3">Pembelajaran 2</a></li>
        </ul>
    </nav>
    <main>
        <section id="section1">
            <h2>Belajar huruf</h2>
            <p style=color:red>*Rekomendasi untuk pemula</p>
            <p>Huruf dalam bahasa jepang dibagi menjadi 3 bagian yaitu hiragana, katakana, dan kanji. Silahkan pelajari dahulu sebelum memulai pembelajaran lanjutan dan test. Kamu juga bisa mendengarkan suara penyebutan hurufnya ketika kamu tap loohh..</p>
            <a href="hiragana.php" class="link-style">
                <label for="container">Hiragana<br>(ひらがな)</label>
            </a>
            <a href="katakana.php" class="link-style">
                <label for="container">Katakana<br>(カタカナ)</label>
            </a>
        </section>
        <section id="section2">
            <h2>Pembelajaran Dasar 1</h2>
            <p>Pada pembelajaran ini, kamu harus menyelesaikan beberapa pelajaran seperti mendengarkan, membaca, maupun penulisan.
                Masing-masing pelajaran ada tingkatan levelnya loh, semakin tinggi maka akan semakin susah pelajarannya. Silahkan pilih pelajaran yang menurutmu mudah dan kamu kuasai. ganbarre~
            </p>
            <a href="task_membaca.php" style="color:black; text-decoration:none;">
            <div class="box-container">
                <img src="../images/icons/book.png" alt="">
                <h4>Membaca</h4>
            </div>
            </a>
            <a href="task_mendengar.php" style="color:black; text-decoration:none;">
            <div class="box-container">
                <img src="../images/icons/listening.png" alt="">
                <h4>Mendengarkan</h4>
            </div>
            </a>
            <a href="task_menulis.php" style="color:black; text-decoration:none;">
            <div class="box-container">
                <img src="../images/icons/write.png" alt="">
                <h4>Penulisan</h4>
            </div>
            </a>
        </section>
        <section id="section3">
            <h2>Pembelajaran Dasar 2</h2>
            <p>Pada pembelajaran ini, kamu harus menyelesaikan pelajaran lanjutan dari pembelajaran dasar 1. Pelajarannya seperti
                percakapan atau pembicaraan dengan orang lain. Ada banyak jenis percakapannya silahkan dipelajari, aku yakin kamu cepat bisa !
            </p>
        <div class="box-container">
            <img src="../images/icons/speaking.png" alt="">
            <h4>Percakapan / Pembicaraan</h4>
        </div>
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
                <li><a href="#section1">Huruf Jepang</a></li>
                <li><a href="#section2">Pembelajaran 1</a></li>
                <li><a href="#section3">Pembelajaran 2</a></li>
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
