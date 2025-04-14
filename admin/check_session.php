<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    echo json_encode(["authenticated" => true, "admin_name" => $_SESSION['admin_name']]);
} else {
    echo json_encode(["authenticated" => false]);
}
?>
