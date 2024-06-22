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
    $id_level = $koneksi->real_escape_string($_POST['id_level']);
    $nama = $koneksi->real_escape_string($_POST['nama']);
    $gambar = $_FILES['gambar'];
    $jawaban_benar = $koneksi->real_escape_string($_POST['jawaban_benar']);

    // Mengambil data foto profile
    $foto_name = $_FILES['gambar']['name'];
    $foto_tmp = $_FILES['gambar']['tmp_name'];
    $foto_size = $_FILES['gambar']['size'];
    $foto_error = $_FILES['gambar']['error'];

    // Tentukan direktori tempat penyimpanan foto
    $foto_dir = "../images/gambar_task/";
    if (!is_dir($foto_dir)) {
        mkdir($foto_dir, 0777, true);
    }

    // Buat nama unik untuk foto profile
    $foto_unique = uniqid() . "_" . $foto_name;
    $targetFile = $foto_dir . $foto_unique;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Memeriksa apakah file benar-benar gambar
    $check = getimagesize($foto_tmp);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Membatasi ukuran file -- 10mb
    if ($foto_size > 10000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Membatasi format file yang diperbolehkan
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Memeriksa apakah $uploadOk bernilai 0 karena error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($foto_tmp, $targetFile)) {
            // Menyimpan data ke database
            $sql = "INSERT INTO task_penulisan (id_level,nama,gambar,jawaban_benar)
            VALUES ('$id_level','$nama','$foto_unique','$jawaban_benar')";

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
    <title>Responsive Carousel Header</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h3>Tambah task menulis</h3>
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group first">
                                <label for="id_gambar" style="font-size:20px;">Task Untuk?</label>
                                <select class="form-control" id="id_level" name="id_level" required>
                                    <option value="">Pilih Level</option>
                                    <?php
                                    include 'koneksi.php';
                                    // Query dengan INNER JOIN
                                    $sql = "SELECT gambar_menulis.id_level, gambar_menulis.level 
                                    FROM gambar_menulis";
                                    $result = $koneksi->query($sql);
                                    if ($result->num_rows > 0) {
                                        // Output data dari setiap baris
                                        while($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row["id_level"] . "'>" . $row["level"] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Tidak ada gambar tersedia</option>";
                                    }
                                    ?>
                                </select>
                                </div>
                                <div class="form-group first">
                                    <label for="nama" style="font-size:20px;">Nama Task</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label for="foto" style="font-size:20px;">Gambar Task</label>
                                </div>
                                    <br>
                                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required onchange="previewImage()">
                                    <br>
                                    <div id="imagePreview" style="width:200px; height:auto;"></div>
                                    <br>
                                <div class="form-group first">
                                    <label for="jawaban_benar" style="font-size:20px;">Jawaban Benar</label>
                                    <input type="text" class="form-control" id="jawaban_benar" name="jawaban_benar" required>
                                </div>
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
    <script>
        function previewImage() {
            var preview = document.getElementById('imagePreview');
            var file = document.getElementById('gambar').files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.innerHTML = '<img src="' + reader.result + '" alt="Foto Profile" class="img-fluid">';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        }
    </script>
</body>
</html>