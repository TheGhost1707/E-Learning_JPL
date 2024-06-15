<?php
include "koneksi.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Di sini Anda dapat memeriksa username dan password dengan data yang ada di database.
    // Gantilah bagian ini dengan logika autentikasi sesuai kebutuhan Anda.
    
    // Contoh query autentikasi dengan MySQL
    $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($koneksi, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Autentikasi berhasil, periksa tipe pengguna dan tetapkan sesi yang sesuai.
        if ($row['role'] == 'Users') {
            $_SESSION['username'] = $username;
            header("Location: users/Dashboard_user.php?notif=user");
            exit();
        } elseif ($row['role'] == 'Admin') {
            $_SESSION['username'] = $username;
            header("Location: admin/Halaman_admin.php?notif=admin");
            exit();
        }
    } else {
        // Autentikasi gagal, tampilkan pesan kesalahan atau redirect ke halaman error.
        header("Location: halaman_error.php");
        exit();
    }
}
?>