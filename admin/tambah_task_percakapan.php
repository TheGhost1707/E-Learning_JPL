<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Konfigurasi database
    $servername = "localhost"; // Ganti dengan nama server Anda
    $username = "root"; // Ganti dengan username database Anda
    $password = ""; // Ganti dengan password database Anda
    $dbname = "e_learning_jpl"; // Ganti dengan nama database Anda

    // Membuat koneksi
    $koneksi = new mysqli($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($koneksi->connect_error) {
        die("Connection failed: " . $koneksi->connect_error);
    }

    // Mengambil data dari formulir
    $jenis_percakapan = $koneksi->real_escape_string($_POST['jenis_percakapan']);
    $video = $_FILES['video'];

    // Mengambil data video
    $video_name = $_FILES['video']['name'];
    $video_tmp = $_FILES['video']['tmp_name'];
    $video_size = $_FILES['video']['size'];
    $video_error = $_FILES['video']['error'];

    // Tentukan direktori tempat penyimpanan video
    $video_dir = "../videos/video_percakapan/";
    if (!is_dir($video_dir)) {
        mkdir($video_dir, 0777, true);
    }

    // Buat nama unik untuk video
    $video_unique = uniqid() . "_" . $video_name;
    $targetFile = $video_dir . $video_unique;
    $videoFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Memeriksa apakah file benar-benar video
    $allowed_extensions = array('mp4', 'avi', 'mov', 'wmv');
    $file_extension = pathinfo($video_name, PATHINFO_EXTENSION);
    if (!in_array($file_extension, $allowed_extensions)) {
        echo "Sorry, only MP4, AVI, MOV, and WMV files are allowed.";
        $uploadOk = 0;
    }

    // Membatasi ukuran file -- 100mb
    if ($video_size > 100000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Memeriksa apakah $uploadOk bernilai 0 karena error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($video_tmp, $targetFile)) {
            // Menyimpan data ke database
            $sql = "INSERT INTO gambar_percakapan (id, jenis_percakapan, video)
            VALUES (NULL, '$jenis_percakapan', '$video_unique')";

            if ($koneksi->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $koneksi->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Menutup koneksi
    $koneksi->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jenis Percakapan</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../images/icons/logo-web.png">
</head>
<body>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-6 contents">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h3>Tambah Percakapan</h3>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group first">
                                <label for="jenis_percakapan" style="font-size:20px;">Jenis Percakapan</label>
                                <input type="text" class="form-control" id="jenis_percakapan" name="jenis_percakapan" required>
                            </div>
                            <div class="form-group">
                                <label for="video" style="font-size:20px;">Video</label>
                            </div>
                            <br>
                                <input type="file" class="form-control" id="video" name="video" accept="video/mp4,video/x-msvideo,video/quicktime,video/x-ms-wmv" required>
                            <br>
                                <input type="submit" value="Selesai" class="btn text-white btn-block btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
</body>
</html>
