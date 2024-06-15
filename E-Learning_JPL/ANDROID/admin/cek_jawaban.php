<?php

// Edit Nilai User
// Select Query
if (isset($_POST['edit'])) {
    $id = $_SESSION['id'];
    $progress_level = 10;

    $query_user = "SELECT * FROM user WHERE id = '$id'";
    $result = $koneksi->query($query);

// Edit Query
if (isset($_POST['edit'])) {
    $id = $_SESSION['id'];
    $progress_level_terbaru = 10;

    $query = "UPDATE user SET progress_level = $query_user['progress_lavel'] + $progress_level_terbaru WHERE id = '$id'";
    $result = $koneksi->query($query);

    if ($result) {
        echo "<script>alert('Nilai berhasil diubah!')</script>";
    } else {
        echo "<script>alert('Nilai gagal diubah!')</script>";
    }
}


?>