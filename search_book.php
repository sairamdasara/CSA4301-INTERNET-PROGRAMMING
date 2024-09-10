<?php
include 'db_connection.php';

$searchQuery = $_GET['query'];

$sql = "SELECT * FROM books WHERE title LIKE '%$searchQuery%' OR author LIKE '%$searchQuery%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Title: " . $row["title"]. " - Author: " . $row["author"]. "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>