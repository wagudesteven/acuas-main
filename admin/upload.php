<?php
// Define the directory where the file will be uploaded
$upload_dir = 'uploads/';  // Make sure this folder exists and has write permissions
$image_name = $_FILES['image']['name'];
$image_tmp_name = $_FILES['image']['tmp_name'];
$image_size = $_FILES['image']['size'];
$image_error = $_FILES['image']['error'];

// Check for file upload errors
if ($image_error !== UPLOAD_ERR_OK) {
    echo "Error during file upload!";
    exit();
}

// Check if the file is an image (optional validation)
$image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];  // Allowed file extensions

if (!in_array(strtolower($image_ext), $allowed_extensions)) {
    echo "Invalid file type! Only JPG, PNG, and GIF files are allowed.";
    exit();
}

// Check if the image size is too large (max size = 2MB in this example)
if ($image_size > 2 * 1024 * 1024) {
    echo "File size is too large! Max size is 2MB.";
    exit();
}

// Generate a unique file name to avoid overwriting existing files
$unique_image_name = time() . '_' . basename($image_name);

// Move the file to the desired directory
$image_path = $upload_dir . $unique_image_name;

if (move_uploaded_file($image_tmp_name, $image_path)) {
    echo "File uploaded successfully!";
    echo " <br> Image Path: " . $image_path;
} else {
    echo "File upload failed!";
}
?>
