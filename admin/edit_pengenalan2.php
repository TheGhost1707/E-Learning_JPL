<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_pengenalan'];
    $huruf_jepang = $koneksi->real_escape_string($_POST['huruf_jepang']);
    $arti_huruf = $koneksi->real_escape_string($_POST['arti_huruf']);

    // Mulai dengan query update dasar
    $updateSql = "UPDATE pengenalan_dasar2 SET huruf_jepang = '$huruf_jepang', arti_huruf = '$arti_huruf'";

    // Proses file gambar baru jika ada
    if (!empty($_FILES['gambar']['name'])) {
        $gambar_name = uniqid() . "_" . basename($_FILES['gambar']['name']);
        $gambar_path = "../images/gambar_task/" . $gambar_name;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar_path)) {
            $updateSql .= ", gambar = '$gambar_name'";
        }
    }

    // Proses file audio baru jika ada
    if (!empty($_FILES['audio']['name'])) {
        $audio_name = uniqid() . "_" . basename($_FILES['audio']['name']);
        $audio_path = "../audio/" . $audio_name;

        if (move_uploaded_file($_FILES['audio']['tmp_name'], $audio_path)) {
            $updateSql .= ", audio = '$audio_name'";
        }
    }

    $updateSql .= " WHERE id_pengenalan = $id";

    if ($koneksi->query($updateSql) === TRUE) {
        echo "Data berhasil diperbarui";
    } else {
        echo "Error: " . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pembelajaran Pengenalan</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../images/icons/logo-web.png">
</head>

<body>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h3>Edit Pembelajaran Dasar Kotoba</h3>
                            </div>
                            <?php
                            include 'koneksi.php';

                            $id_pengenalan = $_GET['id'];
                            $sql = "SELECT * FROM pengenalan_dasar2 WHERE id_pengenalan = $id_pengenalan";
                            $result = $koneksi->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                            } else {
                                echo "Data tidak ditemukan.";
                                exit;
                            }
                            ?>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id_pengenalan" value="<?php echo $row['id_pengenalan']; ?>">

                                <div class="form-group first">
                                    <h3 for="edit_huruf_jepang">Huruf Jepang:</h3>
                                    <input type="text" name="huruf_jepang" value="<?php echo htmlspecialchars($row['huruf_jepang']); ?>" required>
                                </div>

                                <div class="form-group first">
                                    <h3 for="edit_arti_huruf">Arti Huruf:</h3>
                                    <input type="text" name="arti_huruf" value="<?php echo htmlspecialchars($row['arti_huruf']); ?>" required>
                                </div>

                                <div class="form-group">
                                    <h3 for="edit_audio">Audio:</h3>
                                    <input type="file" name="audio" accept="audio/*">
                                    <p>Audio saat ini: <audio controls src="../audio/<?php echo $row['audio']; ?>"></audio></p>
                                </div>

                                <div class="form-group">
                                    <h3 for="edit_gambar">Gambar:</h3>
                                    <input type="file" name="gambar" accept="image/*">
                                    <p>Gambar saat ini: <img src="../images/gambar_task/<?php echo $row['gambar']; ?>" alt="Gambar" width="100px"></p>
                                </div>

                                <button type="submit" class="btn text-white btn-block btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <script>
        function previewImage() {
            var preview = document.getElementById('imagePreview');
            var file = document.getElementById('gambar').files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
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