<?php
include 'init.php';
include 'database.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['destination_id']) && !empty($_POST['destination_id'])) {
    $lokasi_map = [
        'Bantul' => 'ba',
        'Sleman' => 'sl',
        'Yogyakarta' => 'yk',
        'Gunung Kidul' => 'gk',
        'Kulon Progo' => 'kp'
    ];

    $destination_id = (int) $_POST['destination_id'];

    try {
        $info_stmt = $main_conn->prepare("SELECT name, location FROM destinations WHERE id = ?");
        $info_stmt->bind_param("i", $destination_id);
        $info_stmt->execute();
        $info_stmt->bind_result($name, $location);
        $info_stmt->fetch();
        $info_stmt->close();

        if (empty($name) || empty($location)) {
            throw new Exception("Destinasi tidak ditemukan.");
        }

        $kode_lokasi = isset($lokasi_map[$location]) ? $lokasi_map[$location] : 'lainnya';
        $destinasi_slug = strtolower(str_replace(' ', '', trim($name)));
        $dynamic_upload_dir = 'img/assets/' . $kode_lokasi . '/' . $destinasi_slug . '/';

        if (!is_dir($dynamic_upload_dir)) {
            mkdir($dynamic_upload_dir, 0755, true);
        }

        if (isset($_FILES['gallery_images']) && !empty($_FILES['gallery_images']['name'][0])) {
            $gallery_files = $_FILES['gallery_images'];

            $existing_files = glob($dynamic_upload_dir . '*.*');
            $last_num = 0;
            foreach ($existing_files as $file) {
                $num = (int) basename($file, '.' . pathinfo($file, PATHINFO_EXTENSION));
                if ($num > $last_num) {
                    $last_num = $num;
                }
            }
            $file_counter = $last_num + 1;

            $upload_count = 0;

            for ($i = 0; $i < count($gallery_files['name']); $i++) {
                if ($gallery_files['error'][$i] === UPLOAD_ERR_OK) {
                    $gallery_tmp_name = $gallery_files['tmp_name'][$i];
                    $gallery_extension = strtolower(pathinfo($gallery_files['name'][$i], PATHINFO_EXTENSION));
                    $gallery_new_name = $file_counter . '.' . $gallery_extension;
                    $gallery_path = $dynamic_upload_dir . $gallery_new_name;

                    if (move_uploaded_file($gallery_tmp_name, $gallery_path)) {
                        $stmt = $main_conn->prepare("INSERT INTO detail_image (path, destinations_id) VALUES (?, ?)");
                        $stmt->bind_param("si", $gallery_path, $destination_id);
                        $stmt->execute();
                        $stmt->close();
                        $file_counter++;

                        $upload_count++;
                    }
                }
            }
            header("Location: admin.php?status=upload_sukses&count=" . $upload_count . "#unggah-galeri");
            exit();
        } else {
            throw new Exception("Pilih setidaknya satu gambar.");
        }
    } catch (Exception $e) {
        header("Location: admin.php?status=upload_gagal&error=" . urlencode($e->getMessage()) . "#unggah-galeri");
        exit();
    }
} else {
    header("Location: admin.php#unggah-galeri");
    exit();
}
?>