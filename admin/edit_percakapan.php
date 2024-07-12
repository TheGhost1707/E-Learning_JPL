<?php
$koneksi = mysqli_connect("localhost", "root", "", "e_learning_jpl");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$id = $_GET['id'];
$query = "SELECT * FROM gambar_percakapan WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $koneksi->real_escape_string($_POST['id']);
    $jenis_percakapan = $koneksi->real_escape_string($_POST['jenis_percakapan']);
    $video = $_FILES['video'];

    // Mengambil data video baru jika di-upload
    if ($video['name']) {
        $video_unique = $koneksi->real_escape_string($video['name']);
        $video_tmp = $video['tmp_name'];
        $video_size = $video['size'];
        $video_error = $video['error'];

        $target_dir = "../videos/video_task/";
        $target_file = $target_dir . basename($video_unique);

        // Pindahkan file video ke direktori yang ditentukan
        if (move_uploaded_file($video_tmp, $target_file)) {
            // Hapus video lama jika ada
            $query_select_old = "SELECT video FROM gambar_percakapan WHERE id = $id";
            $result_old = mysqli_query($koneksi, $query_select_old);
            $data_old = mysqli_fetch_assoc($result_old);
            if ($data_old['video'] && file_exists($target_dir . $data_old['video'])) {
                unlink($target_dir . $data_old['video']);
            }

            // Update data di database
            $query_update = "UPDATE gambar_percakapan SET jenis_percakapan = '$jenis_percakapan', video = '$video_unique' WHERE id = $id";
            if (mysqli_query($koneksi, $query_update)) {
                echo "Data berhasil diupdate.";
                $data['video'] = $video_unique;
            } else {
                echo "Error updating record: " . mysqli_error($koneksi);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        // Jika tidak ada video baru di-upload, hanya update jenis percakapan
        $query_update = "UPDATE gambar_percakapan SET jenis_percakapan = '$jenis_percakapan' WHERE id = $id";
        if (mysqli_query($koneksi, $query_update)) {
            echo "Data jenis percakapan berhasil diupdate.";
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
                                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                <label for="jenis_percakapan" style="font-size:20px;">Jenis Percakapan :</label><br><br><br>
                                <input type="text" class="form-control" name="jenis_percakapan" id="jenis_percakapan" value="<?php echo $data['jenis_percakapan']; ?>" required><br>
                            </div>
                            <div class="form-group">
                                <label for="video" style="font-size:20px;">Video :</label>
                                <input type="file" class="form-control" name="video" id="video" accept="video/mp4,video/x-msvideo,video/quicktime,video/x-ms-wmv">
                                <video width="320" height="240" controls>
                                    <source src="../videos/video_task/<?php echo $data['video']; ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <br>
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
</body>
</html>
