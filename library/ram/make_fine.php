<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['fine-student-id'];
    $amount = $_POST['fine-amount'];

    $stmt = $conn->prepare("INSERT INTO fines (student_id, amount) VALUES (?, ?)");
    $stmt->bind_param("id", $student_id, $amount);
    $stmt->execute();

    echo 'Fine added successfully';
}
?>
