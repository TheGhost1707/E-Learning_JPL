<?php

// Membuat koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "e_learning_jpl");

// Mengecek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mengambil id_level dari parameter URL
if (isset($_GET['id']) && isset($_GET['tabel'])) {
    $id_level = $_GET['id'];
    $id = $_GET['id'];
    $tabel = $_GET['tabel'];
    $success = true;
    $errors = [];

    switch ($tabel) {
        case 'membaca':
            // Menghapus dari gambar_membaca dan task_membaca
            $query1 = "DELETE FROM gambar_membaca WHERE id_level = '$id_level'";
            $query2 = "DELETE FROM task_membaca WHERE id_level = '$id_level'";
            if (!mysqli_query($koneksi, $query1)) {
                $success = false;
                $errors[] = "Error: " . $query1 . "<br>" . mysqli_error($koneksi);
            }
            if (!mysqli_query($koneksi, $query2)) {
                $success = false;
                $errors[] = "Error: " . $query2 . "<br>" . mysqli_error($koneksi);
            }
            $redirect = "Dashboard_admin.php";
            break;
        case 'menulis':
            // Menghapus dari gambar_menulis dan task_menulis
            $query1 = "DELETE FROM gambar_menulis WHERE id_level = '$id_level'";
            $query2 = "DELETE FROM task_penulisan WHERE id_level = '$id_level'";
            if (!mysqli_query($koneksi, $query1)) {
                $success = false;
                $errors[] = "Error: " . $query1 . "<br>" . mysqli_error($koneksi);
            }
            if (!mysqli_query($koneksi, $query2)) {
                $success = false;
                $errors[] = "Error: " . $query2 . "<br>" . mysqli_error($koneksi);
            }
            $redirect = "Dashboard_admin.php";
            break;
        case 'mendengar':
            // Menghapus dari gambar_mendengar dan task_mendengar
            $query1 = "DELETE FROM gambar_mendengar WHERE id_level = '$id_level'";
            $query2 = "DELETE FROM task_mendengar WHERE id_level = '$id_level'";
            if (!mysqli_query($koneksi, $query1)) {
                $success = false;
                $errors[] = "Error: " . $query1 . "<br>" . mysqli_error($koneksi);
            }
            if (!mysqli_query($koneksi, $query2)) {
                $success = false;
                $errors[] = "Error: " . $query2 . "<br>" . mysqli_error($koneksi);
            }
            $redirect = "Dashboard_admin.php";
            break;
        case 'percakapan':
            // Menghapus dari gambar_percakapan
            $query1 = "DELETE FROM gambar_percakapan WHERE id = '$id'";
            if (!mysqli_query($koneksi, $query1)) {
                $success = false;
                $errors[] = "Error: " . $query1 . "<br>" . mysqli_error($koneksi);
            }
            $redirect = "Dashboard_admin.php";
            break;
            default:
            $success = false;
            $errors[] = "Tabel tidak dikenali.";
            $redirect = "Dashboard_admin.php";
            break;
    }

    // Menutup koneksi database
    mysqli_close($koneksi);

    // Menampilkan pop-up notifikasi menggunakan JavaScript
    echo '<script>';
    if ($success) {
        echo 'alert("Tugas berhasil dihapus.");';
    } else {
        echo 'alert("Terjadi kesalahan saat menghapus: ' . implode(', ', $errors) . '");';
    }
    echo 'window.location.href = "' . $redirect . '";';
    echo '</script>';
} else {
    // ID tugas atau tabel tidak ditemukan
    echo '<script>';
    echo 'alert("ID tugas atau tabel tidak ditemukan.");';
    echo 'window.location.href = "Dashboard_admin.php";';
    echo '</script>';
}
?>
