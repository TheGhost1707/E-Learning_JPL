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



// Query Tambah Data Percakapan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pembuat_pesan = $_POST['pembuat_pesan'];
    $nama_pesan = $_POST['nama_pesan'];
    $kategori = $_POST['kategori'];

    $query_tambah = "INSERT INTO percakapan (pembuat_pesan, nama_pesan, kategori_id, kapan_dibuat) VALUES ('$pembuat_pesan', '$nama_pesan', $kategori, NOW())";
    mysqli_query($koneksi, $query_tambah);

    // Redirect ke halaman ini agar data yang baru ditambahkan muncul
    header("Location: percakapan.php");
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Percakapan dengan Array PHP dan Bootstrap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .chat-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .chat-item {
            margin-bottom: 20px;
            overflow: auto;
        }
        .chat-bubble {
            border-radius: 10px;
            padding: 10px 15px;
            max-width: 70%;
            word-wrap: break-word;
        }
        .chat-bubble.sent {
            background-color: #dcf8c6;
            float: left;
        }
        .chat-bubble.received {
            background-color: #fff;
            float: right;
        }
        .chat-meta {
            font-size: 12px;
            color: #777;
            margin-top: 5px;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="chat-container">
            <h1 class="my-4 text-center">WhatsApp-like Chat</h1>

            <!-- Formulir untuk Ajukan Pesan -->
            <form action="" method="POST">
                <div class="form-group">
                    <label for="pembuat_pesan">Nama Pembuat Pesan:</label>
                    <input type="text" class="form-control" id="pembuat_pesan" name="pembuat_pesan" placeholder="Masukkan nama Anda" required>
                </div>
                <div class="form-group">
                    <label for="nama_pesan">Pesan:</label>
                    <textarea class="form-control" id="nama_pesan" name="nama_pesan" rows="3" placeholder="Tulis pesan Anda" required></textarea>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori:</label>
                    <select class="form-control" id="kategori" name="kategori">
                        <?php foreach ($kategori_percakapan as $kategori): ?>
                            <option value="<?= $kategori['id'] ?>"><?= $kategori['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>

            <hr>

            <!-- Filter Kategori -->
            <div class="form-group">
                <label for="filter_kategori">Filter Kategori:</label>
                <select class="form-control" id="filter_kategori" name="filter_kategori" onchange="filterKategori()">
                    <option value="all">Semua Kategori</option>
                    <?php foreach ($kategori_percakapan as $kategori): ?>
                        <option value="<?= $kategori['id'] ?>"><?= $kategori['nama'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Daftar Percakapan -->
            <div id="chat-list">
                <?php if (count($percakapan) > 0): ?>
                    <?php foreach ($percakapan as $index => $pc): ?>
                        <div class="chat-item" data-kategori-id="<?= $pc['kategori_id'] ?>">
                            <div class="chat-bubble <?= $index % 2 == 0 ? 'sent' : 'received' ?>">
                                <p><?= $pc['pembuat_pesan'] ?>:</p>
                                <p><?= $pc['nama_pesan'] ?></p>
                            </div>
                            <div class="chat-meta">
                                <small class="text-muted"><?= $kategori_percakapan[$pc['kategori_id'] - 1]['nama'] ?> | <?= $pc['kapan_dibuat'] ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="alert alert-info">Tidak ada percakapan.</p>
                <?php endif; ?>
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
            var chatItems = document.querySelectorAll('.chat-item');

            chatItems.forEach(function(item) {
                var kategoriId = item.getAttribute('data-kategori-id');

                if (selectedKategori === 'all' || selectedKategori === kategoriId) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
