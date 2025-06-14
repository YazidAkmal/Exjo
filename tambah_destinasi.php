<?php
include 'init.php'; 
include 'database.php'; 

if (!isset($_SESSION['admin_username'])) {
    die("Akses ditolak. Anda harus login sebagai admin.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['name'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $target_dir = "img/assets/"; 

    $image_name = uniqid() . '_' . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check === false) {
        header("Location: admin.php?status=gagal&error=" . urlencode("File bukan gambar."));
        exit();
    }

    if (file_exists($target_file)) {
        header("Location: admin.php?status=gagal&error=" . urlencode("Nama file sudah ada."));
        exit();
    }

    if ($_FILES["image"]["size"] > 5000000) {
        header("Location: admin.php?status=gagal&error=" . urlencode("Ukuran file terlalu besar."));
        exit();
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        header("Location: admin.php?status=gagal&error=" . urlencode("Hanya format JPG, JPEG, PNG & GIF yang diizinkan."));
        exit();
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_path = $target_file;
        
        $stmt = $main_conn->prepare("INSERT INTO destinations (name, location, description, price, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $name, $location, $description, $price, $image_path);

        if ($stmt->execute()) {
            header("Location: admin.php?status=sukses#tambah-destinasi");
        } else {
            header("Location: admin.php?status=gagal&error=" . urlencode($stmt->error));
        }
        $stmt->close();

    } else {
        header("Location: admin.php?status=gagal&error=" . urlencode("Terjadi kesalahan saat mengunggah file."));
    }
    $main_conn->close();
}
?>