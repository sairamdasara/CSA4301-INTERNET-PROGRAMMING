<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['book-title'];
    $author = $_POST['book-author'];
    $year = $_POST['book-year'];

    $stmt = $conn->prepare("INSERT INTO books (title, author, year) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $author, $year);
    $stmt->execute();

    echo 'Book added successfully';
}
?>
