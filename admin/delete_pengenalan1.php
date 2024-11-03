<?php
include 'koneksi.php';
if (isset($_GET['id'])) {
    // Mendapatkan ID dari URL
    $id_pengenalan = $_GET['id'];

    // Query untuk mengambil path gambar dan audio dari database
    $selectSql = "SELECT gambar FROM pengenalan_dasar2 WHERE id_pengenalan = $id_pengenalan";
    $result = $koneksi->query($selectSql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Hapus file gambar jika ada
        if (!empty($row['gambar']) && file_exists("../images/gambar_task/" . $row['gambar'])) {
            unlink("../images/gambar_task/" . $row['gambar']);
        }
    }

    // Query untuk menghapus data dari database
    $deleteSql = "DELETE FROM pengenalan_dasar1 WHERE id_pengenalan = $id_pengenalan";

    if ($koneksi->query($deleteSql) === TRUE) {
        echo "<script>
            alert('Data berhasil dihapus');
            window.location.href = 'pengenalan_dasar1.php'; // Ganti dengan URL halaman tujuan
          </script>";
    } else {
        echo "<script>
            alert('Error: " . $koneksi->error . "');
            window.location.href = 'pengenalan_dasar1.php'; // Ganti dengan URL halaman tujuan jika tetap ingin dialihkan
          </script>";
    }

    // Tutup koneksi
    $koneksi->close();
    exit;
}
