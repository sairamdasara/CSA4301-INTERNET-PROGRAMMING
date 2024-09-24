<?php
include 'config.php'; // Ensure this file contains correct database connection details

// Query to select all data from a table, e.g., users
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"] . " - Username: " . $row["username"] . "<br>";
        }
    } else {
        echo "0 results";
    }
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>