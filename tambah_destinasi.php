<?php
include 'init.php';
include 'database.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $lokasi_map = [
        'Bantul' => 'ba',
        'Sleman' => 'sl',
        'Yogyakarta' => 'yk',
        'Gunung Kidul' => 'gk',
        'Kulon Progo' => 'kp'
    ];

    $main_conn->begin_transaction();
    try {
        $name = $_POST['name'];
        $location = $_POST['location'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $package_type = $_POST['package_type'];
        $link = $_POST['link'];

        $kode_lokasi = isset($lokasi_map[$location]) ? $lokasi_map[$location] : 'lainnya';
        $destinasi_slug = strtolower(str_replace(' ', '', trim($name)));
        $dynamic_upload_dir = 'img/assets/' . $kode_lokasi . '/' . $destinasi_slug . '/';

        if (!is_dir($dynamic_upload_dir)) {
            mkdir($dynamic_upload_dir, 0755, true);
        }

        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Gambar utama wajib diunggah.");
        }
        $image_tmp_name = $_FILES["image"]["tmp_name"];
        $image_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $image_new_name = 'cover.' . $image_extension;
        $target_file = $dynamic_upload_dir . $image_new_name;

        if (!move_uploaded_file($image_tmp_name, $target_file)) {
            throw new Exception("Gagal mengunggah gambar utama.");
        }
        $image_path_for_db = $target_file;

        $stmt_dest = $main_conn->prepare("INSERT INTO destinations (name, location, description, price, image_path, package_type, link) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_dest->bind_param("sssdsss", $name, $location, $description, $price, $image_path_for_db, $package_type, $link);
        if (!$stmt_dest->execute())
            throw new Exception("Gagal menyimpan destinasi.");

        $new_destination_id = $main_conn->insert_id;
        $stmt_dest->close();

        if (isset($_FILES['gallery_images']) && !empty($_FILES['gallery_images']['name'][0])) {
            $gallery_files = $_FILES['gallery_images'];
            $file_counter = 1;

            for ($i = 0; $i < count($gallery_files['name']); $i++) {
                if ($gallery_files['error'][$i] === UPLOAD_ERR_OK) {
                    $gallery_tmp_name = $gallery_files['tmp_name'][$i];
                    $gallery_extension = strtolower(pathinfo($gallery_files['name'][$i], PATHINFO_EXTENSION));
                    $gallery_new_name = $file_counter . '.' . $gallery_extension;
                    $gallery_path = $dynamic_upload_dir . $gallery_new_name;

                    if (move_uploaded_file($gallery_tmp_name, $gallery_path)) {
                        $stmt_gallery = $main_conn->prepare("INSERT INTO detail_image (path, destinations_id) VALUES (?, ?)");
                        $stmt_gallery->bind_param("si", $gallery_path, $new_destination_id);
                        $stmt_gallery->execute();
                        $stmt_gallery->close();
                        $file_counter++;
                    }
                }
            }
        }

        $main_conn->commit();
        header("Location: admin.php?status=tambah_sukses&context=Destinasi Baru#tambah-destinasi");
        exit();

    } catch (Exception $e) {
        $main_conn->rollback();
        header("Location: admin.php?status=tambah_gagal&error=" . urlencode($e->getMessage()) . "#tambah-destinasi");
        exit();
    }
} else {
    header("Location: admin.php");
    exit();
}
?>