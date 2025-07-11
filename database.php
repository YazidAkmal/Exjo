<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$main_db_host = 'localhost';
$main_db_user = 'exjo';
$main_db_pass = '123';
$main_db_name = 'exjo_db';

$main_conn = new mysqli($main_db_host, $main_db_user, $main_db_pass, $main_db_name);

if ($main_conn->connect_error) {
    die("Main Connection failed: " . $main_conn->connect_error);
}

$admin_db_host = 'localhost';
$admin_db_user = 'exjo';
$admin_db_pass = '123';
$admin_db_name = 'exjo_admin_db';

$admin_conn = new mysqli($admin_db_host, $admin_db_user, $admin_db_pass, $admin_db_name);

if ($admin_conn->connect_error) {
    die("Admin Connection failed: " . $admin_conn->connect_error);
}
?>
