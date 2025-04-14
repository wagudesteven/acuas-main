<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->user_id)) {
    $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, role=? WHERE user_id=?");
    $stmt->bind_param("sssi", $data->full_name, $data->email, $data->role, $data->user_id);

    echo $stmt->execute() ? "User updated successfully" : "Error updating user";
}
?>
