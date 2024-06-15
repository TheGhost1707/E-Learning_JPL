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
}
?>