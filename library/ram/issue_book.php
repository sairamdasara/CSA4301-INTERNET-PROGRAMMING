<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['issue-book-id'];
    $student_id = $_POST['student-id'];
    $issue_date = date('Y-m-d');
    $expiration_date = date('Y-m-d', strtotime('+30 days')); // Example: 30 days later

    $stmt = $conn->prepare("INSERT INTO borrow_history (book_id, student_id, issue_date, expiration_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $book_id, $student_id, $issue_date, $expiration_date);
    $stmt->execute();

    echo 'Book issued successfully';
}
?>
