<?php
session_start();
// Menghubungkan PHP dengan koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "e_learning_jpl");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validasi apakah password dan konfirmasi password sama
    if ($password !== $confirm_password) {
        header("location: register.php?pesan=password_unmatch");
        exit;
    }

    // Mengamankan input dari SQL injection dengan mysqli_real_escape_string
    $nama = mysqli_real_escape_string($koneksi, $nama);
    $username = mysqli_real_escape_string($koneksi, $username);
    $password = mysqli_real_escape_string($koneksi, $password);

    // Query untuk mengecek apakah username sudah digunakan sebelumnya
    $check_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");

    if (mysqli_num_rows($check_username) > 0) {
        // Jika username sudah digunakan sebelumnya, kembalikan ke halaman pendaftaran dengan pesan kesalahan
        header("location: register.php?pesan=username_exists");
        exit;
    }

    // Mengambil data foto profile
    $foto_name = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_size = $_FILES['foto']['size'];
    $foto_error = $_FILES['foto']['error'];

    // Tentukan direktori tempat penyimpanan foto
    $foto_dir = "uploads_profile/";

    // Buat nama unik untuk foto profile
    $foto_unique = uniqid() . "_" . $foto_name;

    // Pindahkan foto profile ke direktori uploads
    move_uploaded_file($foto_tmp, $foto_dir . $foto_unique);

    // Set nilai default progres_level menjadi 0
    $progres_level = 0;

    // Query untuk menyimpan data akun baru ke dalam database
    $query = "INSERT INTO user (nama, username, password, foto_profile, role, progres_level) VALUES ('$nama', '$username', '$password', '$foto_unique', '$role', '$progres_level')";
    if (mysqli_query($koneksi, $query)) {
        // Jika proses penyimpanan berhasil, alihkan ke halaman login dengan pesan sukses
        header("location: index.php?pesan=register_success");
    } else {
        // Jika terjadi kesalahan saat menyimpan data, alihkan ke halaman pendaftaran dengan pesan kesalahan
        header("location: register.php?pesan=register_failed");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="images/icons/logo-web.png">
</head>
<body>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-5 order-md-2">
                    <img src="images/japan.jpeg" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h3>Daftar Akun Baru</h3>
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data" id="registerForm">
                                <div class="form-group first">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="form-group last mb-4">
                                    <label for="confirm_password">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="foto">Foto Profile</label>
                                </div>
                                <br>
                                <input type="file" class="form-control-file" id="foto" name="foto" accept="image/*" required onchange="previewImage()">
                                <div id="imagePreview"></div>
                                <div class="form-group">
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="">Daftar Sebagai</option>
                                        <option value="Users">Pengguna Baru</option>
                                    </select>
                                </div>

                                <input type="submit" value="Daftar" class="btn text-white btn-block btn-primary">
                                <span class="d-block text-left my-4 text-muted">Sudah memiliki akun? <a href="index.php">Login sekarang!</a></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        function previewImage() {
            var preview = document.getElementById('imagePreview');
            var file = document.getElementById('foto').files[0];
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