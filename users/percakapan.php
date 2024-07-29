<?php

// Mengaktifkan session pada PHP
session_start();
// Menghubungkan PHP dengan koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "e_learning_jpl");

// Buat SQL query untuk mengambil data kategori percakapan
$query_kategori = "SELECT * FROM kategori_percakapan";
$hasil_kategori = mysqli_query($koneksi, $query_kategori);
$kategori_percakapan = [];
while ($row = mysqli_fetch_assoc($hasil_kategori)) {
    $kategori_percakapan[] = $row;
}


// Buat SQL query untuk mengambil data percakapan
$query_percakapan = "SELECT * FROM percakapan";
$hasil_percakapan = mysqli_query($koneksi, $query_percakapan);
$percakapan = [];
while ($row = mysqli_fetch_assoc($hasil_percakapan)) {
    $percakapan[] = $row;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Percakapan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style-user.css">
    <link rel="icon" href="../images/icons/logo-web.png">
    <style>
.chat-container {
    max-width: 800px;
    margin: auto;
    padding: 50px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f8f9fa;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.chat-item {
    margin-bottom: 20px;
    overflow: auto;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.chat-bubble {
    border-radius: 10px;
    padding: 10px 15px;
    max-width: 70%;
    word-wrap: break-word;
    position: relative;
    margin-bottom: 5px;
}

.chat-bubble.sent {
    background-color: #dcf8c6;
    align-self: flex-start;
}

.chat-bubble.received {
    background-color: #f1f0f0;
    align-self: flex-end;
}

.chat-meta {
    font-size: 0.9em;
    margin-top: 5px;
}

.sent + .chat-meta .text-muted {
    text-align: left;
    display: block;
}

.received + .chat-meta .text-muted {
    text-align: right;
    display: block;
}

/* Tambahan untuk styling secara umum */
.text-muted {
    color: #6c757d;
    font-size: 0.8em;
    display: block;
}

p {
    margin: 0;
}

/* Untuk memastikan waktu berada di bawah chat bubble */
.chat-item {
    display: flex;
    flex-direction: column;
}

.chat-item .chat-meta {
    align-self: flex-start;
}

.chat-bubble.sent + .chat-meta {
    align-self: flex-start;
}

.chat-bubble.received + .chat-meta {
    align-self: flex-end;
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
    <div class="chat-container">
        <h1 class="my-4 text-center">Pembelajaran Percakapan<br>Bahasa Jepang</h1>
        <hr>
        <!-- Filter Kategori -->
        <div class="form-group">
            <h5 for="filter_kategori">Filter Kategori Percakapan:</h5>
            <select class="form-control" id="filter_kategori" name="filter_kategori" onchange="filterKategori()">
                <option value="" selected disabled>Pilih Kategori</option>
                <?php foreach ($kategori_percakapan as $kategori): ?>
                    <option value="<?= $kategori['id'] ?>"><?= $kategori['nama'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Daftar Percakapan -->
        <div id="chat-list">
            <!-- Percakapan akan ditampilkan di sini setelah kategori dipilih -->
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Fungsi untuk filter percakapan berdasarkan kategori
    function filterKategori() {
        var selectedKategori = document.getElementById('filter_kategori').value;
        var chatList = document.getElementById('chat-list');

        // Bersihkan chat list
        chatList.innerHTML = '';

        <?php if (count($percakapan) > 0): ?>
            var percakapan = <?= json_encode($percakapan) ?>;

            percakapan.forEach(function(pc, index) {
                if (pc.kategori_id == selectedKategori) {
                    var chatItem = document.createElement('div');
                    chatItem.classList.add('chat-item');

                    var chatBubble = document.createElement('div');
                    chatBubble.classList.add('chat-bubble', (index % 2 == 0 ? 'sent' : 'received'));

                    var pembuatPesan = document.createElement('p');
                    pembuatPesan.innerText = pc.pembuat_pesan + ':';

                    var namaPesan = document.createElement('p');
                    namaPesan.innerText = pc.nama_pesan;

                    chatBubble.appendChild(pembuatPesan);
                    chatBubble.appendChild(namaPesan);

                    var chatMeta = document.createElement('div');
                    chatMeta.classList.add('chat-meta');

                    var chatMetaText = document.createElement('small');
                    chatMetaText.classList.add('text-muted');
                    chatMetaText.innerText = pc.kapan_dibuat;

                    chatMeta.appendChild(chatMetaText);

                    chatItem.appendChild(chatBubble);
                    chatItem.appendChild(chatMeta);

                    chatList.appendChild(chatItem);
                }
            });
        <?php else: ?>
            var noChatMessage = document.createElement('p');
            noChatMessage.classList.add('alert', 'alert-info');
            noChatMessage.innerText = 'Tidak ada percakapan untuk saat ini.';
            chatList.appendChild(noChatMessage);
        <?php endif; ?>
    }
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
