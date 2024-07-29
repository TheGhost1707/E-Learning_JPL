<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task mendengar admin</title>
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
    </style>
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
    <a href="tambah_level_mendengar.php" style="color:white; text-decoration:none" id="tambahLevelLink">
        <button class="btn-tambah-lvl">Tambah level</button>
    </a>
    <div id="popup1" class="popup">
        <div class="popup-content">
            <span class="close" id="close1">&times;</span>
            <iframe src="tambah_level_mendengar.php" width="100%" height="400px"></iframe>
        </div>
    </div>

    <a href="tambah_task_mendengar.php" style="color:white; text-decoration:none" id="tambahTaskLink">
        <button class="btn-tambah-lvl">Tambah task</button>
    </a>
    <div id="popup2" class="popup">
        <div class="popup-content">
            <span class="close" id="close2">&times;</span>
            <iframe src="tambah_task_mendengar.php" width="100%" height="400px"></iframe>
        </div>
    </div>

    <div id="popupEdit" class="popup">
        <div class="popup-content">
            <span class="close" id="closeEdit">&times;</span>
            <iframe id="editFrame" src="" width="100%" height="400px"></iframe>
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

        // Script untuk pop-up Edit
        var popupEdit = document.getElementById('popupEdit');
        var spanEdit = document.getElementById('closeEdit');

        function openEditPopup(id) {
            document.getElementById('editFrame').src = 'edit_mendengar.php?id=' + id;
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
// Membuat koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "e_learning_jpl");

// Mengecek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mengambil data dari tabel gambar_membaca
$query = "SELECT id_level, gambar, level FROM gambar_mendengar";
$result = mysqli_query($koneksi, $query);

// Mengecek apakah ada data yang ditemukan
if (mysqli_num_rows($result) > 0) {
    echo '<div class="task-container">';
    
    // Menampilkan data dalam format HTML
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="task-item">';
        echo '<a href="task2.php?id=' . $row['id_level'] . '" style="color:black; text-decoration:none;">';
        echo '<img src="../images/gambar_task/' . $row['gambar'] . '" alt="Task Image ' . $row['id_level'] . '">';
        echo '<p>Level ' . $row['level'] . '</p>';
        echo '</a>';
        echo '<a href="#" onclick="openEditPopup(' . $row['id_level'] . ')" class="edit_button">Edit</a>';
        echo '<a href="delete.php?id=' . $row['id_level'] . '&tabel=mendengar" class="delete_button" onclick="return confirm(\'Anda yakin ingin menghapus tugas ini?\')">Delete</a>';
        echo '</div>';
    }
    
    echo '</div>';
} else {
    echo "<center>Tugas tidak tersedia untuk saat ini!</center>";
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
