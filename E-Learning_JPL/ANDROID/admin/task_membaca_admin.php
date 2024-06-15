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
        $sql = "SELECT nama, role, foto_profile FROM user WHERE id = '$id'";
        $result = mysqli_query($koneksi, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Ambil data nama, dan gambar profil
            $row = mysqli_fetch_assoc($result);
            $nama = $row["nama"];
            $role = $row["role"];
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
            echo "<p>($role)</p>";
            echo "</div>";
        } else {
            echo "0 results";
        }
    }
    ?>
</div>
</header>
<main>
    <a href="tambah_level_membaca.php" style="color:white; text-decoration:none" id="tambahLevelLink">
        <button class="btn-tambah-lvl">Tambah level</button>
    </a>
    <div id="popup1" class="popup">
        <div class="popup-content">
            <span class="close" id="close1">&times;</span>
            <iframe src="tambah_level_membaca.php" width="100%" height="400px"></iframe>
        </div>
    </div>

    <a href="tambah_task_membaca.php" style="color:white; text-decoration:none" id="tambahTaskLink">
        <button class="btn-tambah-lvl">Tambah task</button>
    </a>
    <div id="popup2" class="popup">
        <div class="popup-content">
            <span class="close" id="close2">&times;</span>
            <iframe src="tambah_task_membaca.php" width="100%" height="400px"></iframe>
        </div>
    </div>

    <script>
        // Tangkap elemen untuk pop-up pertama
        var link1 = document.getElementById('tambahLevelLink');
        var popup1 = document.getElementById('popup1');
        var span1 = document.getElementById('close1');

        // Fungsi untuk menampilkan pop-up pertama
        link1.onclick = function(event) {
            event.preventDefault();
            popup1.style.display = 'block';
        }

        // Fungsi untuk menyembunyikan pop-up pertama
        span1.onclick = function() {
            popup1.style.display = 'none';
        }

        // Fungsi untuk menyembunyikan pop-up pertama ketika klik di luar konten
        window.onclick = function(event) {
            if (event.target == popup1) {
                popup1.style.display = 'none';
            }
        }

        // Tangkap elemen untuk pop-up kedua
        var link2 = document.getElementById('tambahTaskLink');
        var popup2 = document.getElementById('popup2');
        var span2 = document.getElementById('close2');

        // Fungsi untuk menampilkan pop-up kedua
        link2.onclick = function(event) {
            event.preventDefault();
            popup2.style.display = 'block';
        }

        // Fungsi untuk menyembunyikan pop-up kedua
        span2.onclick = function() {
            popup2.style.display = 'none';
        }

        // Fungsi untuk menyembunyikan pop-up kedua ketika klik di luar konten
        window.onclick = function(event) {
            if (event.target == popup2) {
                popup2.style.display = 'none';
            }
        }
    </script>
<?php
// Membuat koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "e_learning_jpl");

// Mengecek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mengambil data dari tabel gambar_membaca
$query = "SELECT id_level, gambar, level FROM gambar_membaca";
$result = mysqli_query($koneksi, $query);

// Mengecek apakah ada data yang ditemukan
if (mysqli_num_rows($result) > 0) {
    echo '<div class="task-container">';
    
    // Menampilkan data dalam format HTML
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="task-item">';
        echo '<a href="task1.php?id=' . $row['id_level'] . '" style="color:black; text-decoration:none;">';
        echo '<img src="../images/gambar_task/' . $row['gambar'] . '" alt="Task Image ' . $row['id_level'] . '">';
        echo '<p>Level ' . $row['level'] . '</p>';
        echo '</a>';
        echo '</div>';
    }
    
    echo '</div>';
} else {
    echo "Tugas tidak tersedia untuk saat ini!";
}

// Menutup koneksi database
mysqli_close($koneksi);
?>

<!-- JavaScript untuk menangani klik gambar -->
<script>
function showTask(id_gambar) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_task.php?id_gambar=' + id_gambar, true);
    xhr.onload = function() {
        if (this.status == 200) {
            document.getElementById('task-detail').innerHTML = this.responseText;
        }
    };
    xhr.send();
}
</script>
<div id="task-detail"></div>
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
