<?php 
// Mengaktifkan session pada PHP
session_start();
 
// Menghubungkan PHP dengan koneksi database
$koneksi = mysqli_connect("localhost","root","","e_learning_jpl");

// Memeriksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Menangkap data yang dikirim dari form login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mengamankan input dari SQL injection dengan mysqli_real_escape_string
    $username = mysqli_real_escape_string($koneksi, $username);
    $password = mysqli_real_escape_string($koneksi, $password);

    // Menyeleksi data user dengan username dan password yang sesuai
    $login = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");
    // Menghitung jumlah data yang ditemukan
    $cek = mysqli_num_rows($login);
    
    // Cek apakah username dan password ditemukan pada database
    if($cek > 0){
        $data = mysqli_fetch_assoc($login);
        // Simpan ID pengguna ke dalam session
        $_SESSION['id'] = $data['id'];
        // Cek jika user login sebagai user
        if($data['role']=="Admin"){
            // Buat session role
            $_SESSION['role'] = "Admin";
            // Alihkan ke halaman dashboard pengguna
            header("location:Dashboard_admin.php?pesan=sukses");
            exit();
        } else {
            // Autentikasi gagal, tampilkan pesan kesalahan.
            header("Location: index.php?pesan=gagal");
            exit();
        }
    } else {
        // Jika username atau password tidak ditemukan
        header("Location: index.php?pesan=gagal");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-learning Japanese Language</title>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .notification {
            padding: 15px;
            border-radius: 5px;
            color: white;
            text-align: center;
            width: 300px;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s, visibility 0.5s;
        }
        .notification.success {
            background-color: #4CAF50;
        }
        .notification.error {
            background-color: red;
        }
        .notification.show {
            opacity: 1;
            visibility: visible;
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
    <?php
    // Menangkap pesan notifikasi jika ada
    if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal') {
        echo "<div class='notification error'><h3>Login gagal!</h3>Silahkan cek kembali password dan username anda.</div>";
    }
    ?>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-5 order-md-2">
                    <img src="../images/japan.jpeg" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h3>Log In to Admin <strong>E-learning Japanese Language </strong></h3>
                                <p class="mb-4">Silahkan login, sebelum memulai aplikasi.</p>
                            </div>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <div class="form-group first">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="d-flex mb-5 align-items-center">
                                    <label class="control control--checkbox mb-0">
                                        <span class="caption">Ingat Saya</span>
                                        <input type="checkbox" name="remember_me" checked="checked"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                    <span class="ml-auto"><a href="forget_password.php" class="forgot-pass"></a></span> 
                                </div>
                                <input type="submit" value="Masuk" class="btn text-white btn-block btn-primary">
                                <span class="d-block text-left my-4 text-muted">Belum memiliki akun? <a href="register_admin.php">Daftar sekarang!</a></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
</body>
</html>
