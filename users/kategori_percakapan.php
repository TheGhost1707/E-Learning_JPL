<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task membaca</title>
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
<main>
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
        echo '<a href="task1_user.php?id=' . $row['id_level'] . '" style="color:black; text-decoration:none;">';
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
