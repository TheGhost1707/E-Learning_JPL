<?php
include 'koneksi.php';
if (isset($_GET['id'])) {
    // Mendapatkan ID dari URL
    $id_pengenalan = $_GET['id'];

    // Query untuk mengambil path gambar dan audio dari database
    $selectSql = "SELECT gambar, audio FROM pengenalan_dasar2 WHERE id_pengenalan = $id_pengenalan";
    $result = $koneksi->query($selectSql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Hapus file gambar jika ada
        if (!empty($row['gambar']) && file_exists("../images/gambar_task/" . $row['gambar'])) {
            unlink("../images/gambar_task/" . $row['gambar']);
        }

        // Hapus file audio jika ada
        if (!empty($row['audio']) && file_exists("../audio/" . $row['audio'])) {
            unlink("../audio/" . $row['audio']);
        }
    }

    // Query untuk menghapus data dari database
    $deleteSql = "DELETE FROM pengenalan_dasar2 WHERE id_pengenalan = $id_pengenalan";

    if ($koneksi->query($deleteSql) === TRUE) {
        echo "<script>
            alert('Data berhasil dihapus');
            window.location.href = 'pengenalan_dasar2.php'; // Ganti dengan URL halaman tujuan
          </script>";
    } else {
        echo "<script>
            alert('Error: " . $koneksi->error . "');
            window.location.href = 'pengenalan_dasar2.php'; // Ganti dengan URL halaman tujuan jika tetap ingin dialihkan
          </script>";
    }

    // Tutup koneksi
    $koneksi->close();

    // Redirect ke halaman sebelumnya atau halaman lain
    header("Location: pengenalan_dasar2.php"); // Ganti 'index.php' dengan halaman yang sesuai
    exit;
} else {
    echo "ID tidak ditemukan.";
}
