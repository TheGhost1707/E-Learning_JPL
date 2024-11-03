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
    $huruf_jepang = $koneksi->real_escape_string($_POST['huruf_jepang']);
    $arti_huruf = $koneksi->real_escape_string($_POST['arti_huruf']);
    $kategori = $koneksi->real_escape_string($_POST['kategori']);
    $gambar = $_FILES['gambar'];

    // Mengambil data foto
    $foto_name = $_FILES['gambar']['name'];
    $foto_tmp = $_FILES['gambar']['tmp_name'];
    $foto_size = $_FILES['gambar']['size'];
    $foto_error = $_FILES['gambar']['error'];

    // Tentukan direktori tempat penyimpanan foto
    $foto_dir = "../images/gambar_task/";
    if (!is_dir($foto_dir)) {
        mkdir($foto_dir, 0777, true);
    }

    // Buat nama unik untuk foto
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
        echo "<script>
            alert('Maaf, file Anda tidak dapat diunggah.');
            window.location.href = 'pengenalan_dasar1.php'; // Ganti dengan URL halaman error yang diinginkan
          </script>";
    } else {
        if (move_uploaded_file($foto_tmp, $targetFile)) {
            // Menyimpan data ke database
            $sql = "INSERT INTO pengenalan_dasar1 (huruf_jepang, arti_huruf, kategori, gambar) VALUES ('$huruf_jepang', '$arti_huruf', '$kategori', '$foto_unique')";

            if ($koneksi->query($sql) === TRUE) {
                echo "<script>
                    alert('Data berhasil ditambahkan');
                    window.location.href = 'pengenalan_dasar1.php'; // Ganti dengan URL halaman sukses yang diinginkan
                  </script>";
            } else {
                echo "<script>
                    alert('Error: " . $koneksi->error . "');
                    window.location.href = 'pengenalan_dasar1.php'; // Ganti dengan URL halaman error yang diinginkan
                  </script>";
            }
        } else {
            echo "<script>
                alert('Maaf, terjadi kesalahan saat mengunggah file Anda.');
                window.location.href = 'pengenalan_dasar1.php'; // Ganti dengan URL halaman error yang diinginkan
              </script>";
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
    <title>Tambah Pembelajaran Pengenalan</title>
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
                                <h3>Tambah Pembelajaran Dasar Kotoba</h3>
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group first">
                                    <label for="kategori" style="font-size:20px;">Kategori Pengenalan</label>
                                    <br>
                                    <br>
                                    <br>
                                    <select class="form-control" id="kategori" name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Buah">Buah</option>
                                        <option value="Kendaraan">Kendaraan</option>
                                        <option value="Hewan">Hewan</option>
                                        <option value="Keluarga">Keluarga</option>
                                    </select>
                                </div>
                                <div class="form-group first">
                                    <label for="huruf_jepang" style="font-size:20px;">Huruf Jepang</label>
                                    <input type="text" class="form-control" id="huruf_jepang" name="huruf_jepang" required>
                                </div>
                                <div class="form-group first">
                                    <label for="arti_huruf" style="font-size:20px;">Arti Huruf</label>
                                    <input type="text" class="form-control" id="arti_huruf" name="arti_huruf" required>
                                </div>
                                <div class="form-group">
                                    <label for="foto" style="font-size:20px;">Gambar</label>
                                </div>
                                <br>
                                <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*" required onchange="previewImage()">
                                <br>
                                <div id="imagePreview" style="width:200px; height:auto;"></div>
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

            reader.onloadend = function() {
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