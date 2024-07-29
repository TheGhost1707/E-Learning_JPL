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

    // Fungsi untuk mengupload file
    function uploadFile($file, $directory, $allowed_types, $max_size) {
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

        // Tentukan direktori tempat penyimpanan file
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        // Buat nama unik untuk file
        $file_unique = uniqid() . "_" . $file_name;
        $targetFile = $directory . $file_unique;
        $fileFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $uploadOk = 1;

        // Memeriksa apakah file sesuai dengan tipe yang diperbolehkan
        if (!in_array($fileFileType, $allowed_types)) {
            echo "Sorry, only " . implode(", ", $allowed_types) . " files are allowed.";
            $uploadOk = 0;
        }

        // Membatasi ukuran file
        if ($file_size > $max_size) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Memeriksa apakah $uploadOk bernilai 0 karena error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            return false;
        } else {
            if (move_uploaded_file($file_tmp, $targetFile)) {
                return $file_unique;
            } else {
                echo "Sorry, there was an error uploading your file.";
                return false;
            }
        }
    }

    // Direktori penyimpanan file
    $image_dir = "../images/gambar_task/";
    $audio_dir = "../audio/";

    // Mengunggah gambar
    $gambar_benar = uploadFile($_FILES['gambar_benar'], $image_dir, ['jpg', 'jpeg', 'png', 'gif'], 10000000);
    $gambar_salah1 = uploadFile($_FILES['gambar_salah1'], $image_dir, ['jpg', 'jpeg', 'png', 'gif'], 10000000);
    $gambar_salah2 = uploadFile($_FILES['gambar_salah2'], $image_dir, ['jpg', 'jpeg', 'png', 'gif'], 10000000);
    $gambar_salah3 = uploadFile($_FILES['gambar_salah3'], $image_dir, ['jpg', 'jpeg', 'png', 'gif'], 10000000);
    $audio_unique = uploadFile($_FILES['audio'], $audio_dir, ['mp3', 'wav', 'ogg'], 10000000);

    if ($gambar_benar && $gambar_salah1 && $gambar_salah2 && $gambar_salah3 && $audio_unique) {
        // Menyimpan data ke database
        $sql = "INSERT INTO task_mendengar (id_level, nama, gambar_benar, gambar_salah1, gambar_salah2, gambar_salah3, audio)
                VALUES ('$id_level', '$nama', '$gambar_benar', '$gambar_salah1', '$gambar_salah2', '$gambar_salah3', '$audio_unique')";

        if ($koneksi->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
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
                                <h3>Tambah task mendengar</h3>
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group first">
                                <label for="id_gambar" style="font-size:20px;">Task Untuk?</label>
                                <br>
                                <br>
                                <select class="form-control" id="id_level" name="id_level" required>
                                    <option value="">Pilih Level</option>
                                    <?php
                                    include 'koneksi.php';
                                    // Query dengan INNER JOIN
                                    $sql = "SELECT gambar_mendengar.id_level, gambar_mendengar.level 
                                    FROM gambar_mendengar";
                                    $result = $koneksi->query($sql);
                                    if ($result->num_rows > 0) {
                                        // Output data dari setiap baris
                                        while($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row["id_level"] . "'>" . $row["level"] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Tidak ada level tersedia</option>";
                                    }
                                    ?>
                                </select>
                                </div>
                                <div class="form-group first">
                                    <label for="nama" style="font-size:20px;">Nama Task</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="form-group first">
                                    <label for="nama" style="font-size:20px;">Audio Task</label>
                                </div>
                                <br>
                                <input type="file" class="form-control" id="audio" name="audio" required>
                                <br>
                                <div class="form-group first">
                                    <label for="gambar_benar" style="font-size:20px;">Gambar Benar</label>
                                </div>
                                <input type="file" class="form-control" id="gambar" name="gambar_benar" accept="image/*" required onchange="previewImage()">
                                    <br>
                                    <div id="imagePreview" style="width:200px; height:auto;"></div>
                                    <br>
                                <div class="form-group first">
                                    <label for="gambar_salah1" style="font-size:20px;">Gambar Salah 1</label>
                                </div>
                                <input type="file" class="form-control" id="gambar1" name="gambar_salah1" accept="image/*" required onchange="previewImage1()">
                                    <br>
                                    <div id="imagePreview1" style="width:200px; height:auto;"></div>
                                    <br>
                                <div class="form-group first">
                                    <label for="gambar_salah2" style="font-size:20px;">Gambar Salah 2</label>
                                </div>
                                <input type="file" class="form-control" id="gambar2" name="gambar_salah2" accept="image/*" required onchange="previewImage2()">
                                    <br>
                                    <div id="imagePreview2" style="width:200px; height:auto;"></div>
                                    <br>
                                <div class="form-group first">
                                    <label for="gambar_salah3" style="font-size:20px;">Gambar Salah 3</label>
                                </div>
                                <input type="file" class="form-control" id="gambar3" name="gambar_salah3" accept="image/*" required onchange="previewImage3()">
                                    <br>
                                    <div id="imagePreview3" style="width:200px; height:auto;"></div>
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
        function previewImage1() {
            var preview = document.getElementById('imagePreview1');
            var file = document.getElementById('gambar1').files[0];
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
        function previewImage2() {
            var preview = document.getElementById('imagePreview2');
            var file = document.getElementById('gambar2').files[0];
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
        function previewImage3() {
            var preview = document.getElementById('imagePreview3');
            var file = document.getElementById('gambar3').files[0];
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