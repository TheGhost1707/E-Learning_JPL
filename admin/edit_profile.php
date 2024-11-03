<!-- edit_profile.php -->
<?php
// Include database connection
include('koneksi.php'); // Adjust to your database connection file

// Retrieve current user data
session_start();
$id = $_SESSION['id']; // Assuming you have a session storing the user ID

// Fetch current name and profile picture
$query = "SELECT nama, foto_profile FROM user WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (isset($_POST['update_profile'])) {
    $nama = $_POST['nama'];
    $foto_profile = $_FILES['foto_profile'];

    // Update full name
    $query = "UPDATE user SET nama = ? WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("si", $nama, $user_id);
    $stmt->execute();

    // Handle profile picture upload if a new file is uploaded
    if ($foto_profile['error'] == 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($foto_profile["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allow only certain file formats
        if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            if (move_uploaded_file($foto_profile["tmp_name"], $target_file)) {
                // Update profile picture path in database
                $query = "UPDATE user SET foto_profile = ? WHERE id = ?";
                $stmt = $koneksi->prepare($query);
                $stmt->bind_param("si", $foto_profile["name"], $id);
                $stmt->execute();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    // Redirect back to profile page or a success page
    header("Location: dashboard_admin.php");
}
?>