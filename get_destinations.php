<?php
include 'init.php';
include 'database.php';
header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    $stmt = $main_conn->prepare("SELECT id, name, location, price, description, link, package_type FROM destinations WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    echo json_encode($data);
    $stmt->close();
    exit();
}

$main_conn->close();
?>