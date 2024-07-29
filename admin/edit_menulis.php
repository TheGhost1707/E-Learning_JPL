<?php
$koneksi = mysqli_connect("localhost", "root", "", "e_learning_jpl");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$id_level = $_GET['id'];
$query = "SELECT * FROM gambar_menulis WHERE id_level = $id_level";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_level = $koneksi->real_escape_string($_POST['id_level']);
    $level = $koneksi->real_escape_string($_POST['level']);
    $gambar = $_FILES['gambar'];

    // Mengambil data foto baru jika di-upload
    if ($gambar['name']) {
        $foto_unique = $koneksi->real_escape_string($gambar['name']);
        $foto_tmp = $gambar['tmp_name'];
        $foto_size = $gambar['size'];
        $foto_error = $gambar['error'];

        $target_dir = "../images/gambar_task/";
        $target_file = $target_dir . basename($foto_unique);

        // Pindahkan file gambar ke direktori yang ditentukan
        if (move_uploaded_file($foto_tmp, $target_file)) {
            // Hapus gambar lama jika ada
            $query_select_old = "SELECT gambar FROM gambar_menulis WHERE id_level = $id_level";
            $result_old = mysqli_query($koneksi, $query_select_old);
            $data_old = mysqli_fetch_assoc($result_old);
            if ($data_old['gambar'] && file_exists($target_dir . $data_old['gambar'])) {
                unlink($target_dir . $data_old['gambar']);
            }

            // Update data di database
            $query_update = "UPDATE gambar_menulis SET level = '$level', gambar = '$foto_unique' WHERE id_level = $id_level";
            if (mysqli_query($koneksi, $query_update)) {
                echo "Data berhasil diupdate.";
                $data['gambar'] = $foto_unique;
            } else {
                echo "Error updating record: " . mysqli_error($koneksi);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        // Jika tidak ada gambar baru di-upload, hanya update level
        $query_update = "UPDATE gambar_menulis SET level = '$level' WHERE id_level = $id_level";
        if (mysqli_query($koneksi, $query_update)) {
            echo "Data level berhasil diupdate.";
        } else {
            echo "Error updating record: " . mysqli_error($koneksi);
        }
    }
}

mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Level Mendengar</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
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
                            <h3>Edit Level Mendengar</h3>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group first">
                                <input type="hidden" name="id_level" value="<?php echo $data['id_level']; ?>">
                                <label for="level" style="font-size:20px;">Level :</label><br><br><br>
                                <input type="text" class="form-control" name="level" id="level" value="<?php echo $data['level']; ?>" required><br>
                            </div>
                            <div class="form-group">
                                <label for="gambar" style="font-size:20px;">Gambar :</label>
                            </div>
                            <br>
                            <input type="file" class="form-control" name="gambar" id="gambar" onchange="previewImage()">
                            <img src="../images/gambar_task/<?php echo $data['gambar']; ?>" alt="Gambar" width="200" height="auto" id="imagePreview"><br><br>
                            <input type="submit" value="Update" class="btn text-white btn-block btn-primary">
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

        reader.onloadend = function () {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "../images/gambar_task/<?php echo $data['gambar']; ?>";
        }
    }
</script>
</body>
</html>
