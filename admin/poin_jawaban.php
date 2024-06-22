<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "e_learning_jpl");

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $pointsToAdd = 10;

    // Dapatkan poin saat ini dari database
    $sql = "SELECT progres_level FROM user WHERE id = '$id'";
    $result = mysqli_query($koneksi, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentPoints = $row['progres_level'];

        // Tambahkan poin baru
        $newPoints = $currentPoints + $pointsToAdd;

        // Perbarui poin di database
        $updateSql = "UPDATE user SET progres_level = '$newPoints' WHERE id = '$id'";
        if (mysqli_query($koneksi, $updateSql)) {
            echo json_encode(["success" => true, "newPoints" => $newPoints]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to update points."]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "User not found."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "User not logged in."]);
}

mysqli_close($koneksi);
?>