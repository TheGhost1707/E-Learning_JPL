<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task membaca Admin</title>
    <link rel="stylesheet" href="../css/style-user.css">
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
    .task-item{
        width:400px;
    }
    /* Media query untuk layar kecil (< 768px) */
    @media screen and (max-width: 768px) {
        .task-item video {
            width:360px;
            height:auto;
        }
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
    <a href="tambah_task_percakapan.php" style="color:white; text-decoration:none" id="tambahTaskLink">
        <button class="btn-tambah-lvl">Tambah Task</button>
    </a>
    <div id="popup2" class="popup">
        <div class="popup-content">
            <span class="close" id="close2">&times;</span>
            <iframe src="tambah_task_percakapan.php" width="100%" height="400px"></iframe>
        </div>
    </div>

    <!-- Pop-up untuk Edit -->
    <div id="popupEdit" class="popup">
        <div class="popup-content">
            <span class="close" id="closeEdit">&times;</span>
            <iframe id="editFrame" width="100%" height="400px"></iframe>
        </div>
    </div>

    <script>

        // Script untuk pop-up Tambah Task
        var link2 = document.getElementById('tambahTaskLink');
        var popup2 = document.getElementById('popup2');
        var span2 = document.getElementById('close2');

        link2.onclick = function(event) {
            event.preventDefault();
            popup2.style.display = 'block';
        }

        span2.onclick = function() {
            popup2.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == popup2) {
                popup2.style.display = 'none';
            }
        }

        // Script untuk pop-up Edit
        var popupEdit = document.getElementById('popupEdit');
        var spanEdit = document.getElementById('closeEdit');

        function openEditPopup(id) {
            document.getElementById('editFrame').src = 'edit_percakapan.php?id=' + id;
            popupEdit.style.display = 'block';
        }

        spanEdit.onclick = function() {
            popupEdit.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == popupEdit) {
                popupEdit.style.display = 'none';
            }
        }
    </script>
    <?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "e_learning_jpl");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$query = "SELECT id, jenis_percakapan, video FROM gambar_percakapan";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="task-container">';
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="task-item">';
        echo '<video width="400" height="300" controls id="video_' . $row['id'] . '">';
        echo '<source src="../videos/video_percakapan/' . $row['video'] . '" type="video/mp4">';
        echo 'Your browser does not support the video tag.';
        echo '</video>';
        echo '<p>' . $row['jenis_percakapan'] . '</p>';
        echo '<a href="#" onclick="openEditPopup(' . $row['id'] . ')" class="edit_button">Edit</a>';
        echo '<a href="delete.php?id=' . $row['id'] . '&tabel=percakapan" class="delete_button" onclick="return confirm(\'Anda yakin ingin menghapus percakapan ini?\')">Delete</a>';
        echo '</div>';
    }
    
    echo '</div>';
} else {
    echo "<p style='text-align:center;'>Percakapan tidak tersedia untuk saat ini!</p>";
}

mysqli_close($koneksi);
?>

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