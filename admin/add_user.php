<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->full_name)) {
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
    $hashed_password = password_hash($data->password, PASSWORD_DEFAULT);
    $stmt->bind_param("ssss", $data->full_name, $data->email, $hashed_password, $data->role);

    echo $stmt->execute() ? "User added successfully" : "Error adding user";
}
?>
