<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    if ($fileError === 0) {
        if ($fileSize < 1000000) { // Limit file size to 1MB
            $fileDestination = 'uploads/' . $fileName;
            move_uploaded_file($fileTmpName, $fileDestination);
            echo "File uploaded successfully";
        } else {
            echo "File size is too big";
        }
    } else {
        echo "There was an error uploading your file";
    }
}

$conn->close();
?>