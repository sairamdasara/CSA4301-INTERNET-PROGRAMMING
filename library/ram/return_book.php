<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['return-book-id'];
    $student_id = $_POST['return-student-id'];

    $stmt = $conn->prepare("DELETE FROM borrow_history WHERE book_id = ? AND student_id = ?");
    $stmt->bind_param("ii", $book_id, $student_id);
    $stmt->execute();

    echo 'Book returned successfully';
}
?>
