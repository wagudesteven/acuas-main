<?php
$password = "admin1234"; // User input password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
echo $hashedPassword;

?>
