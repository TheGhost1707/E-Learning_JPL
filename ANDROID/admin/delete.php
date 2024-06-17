<?php

// Membuat koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "e_learning_jpl");

// Mengecek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mengambil id_level dari parameter URL
if (isset($_GET['id'])) {
    $id_level = $_GET['id'];

    // Query untuk menghapus tugas
    $query = "DELETE FROM gambar_membaca WHERE id_level = '$id_level'";

    if (mysqli_query($koneksi, $query)) {
        // Tugas berhasil dihapus
        echo "Tugas berhasil dihapus.";

        // Menutup koneksi database
        mysqli_close($koneksi);

        // Menampilkan pop-up notifikasi menggunakan JavaScript
        echo '<script>';
        echo 'alert("Tugas berhasil dihapus.");';
        echo 'window.location.href = "task_membaca_admin.php";'; 
        echo '</script>';
    } else {
        // Error saat menghapus
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
} else {
    // ID tugas tidak ditemukan
        echo '<script>';
        echo 'alert("Terjadi kesalahan saat menghapus.");';
        echo 'window.location.href = "task_membaca_admin.php";'; 
        echo '</script>';
}

// Menutup koneksi database
mysqli_close($koneksi);
?>