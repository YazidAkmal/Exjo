<?php
session_start();

$cookie_name = "user_activity";
$cookie_value = "active";
$expiration_time = time() + 3600;
setcookie($cookie_name, $cookie_value, $expiration_time, "/");

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
?>