<?php
// Include the configuration file
include 'config.php';

// Write your database queries here
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"] . " - Title: " . $row["title"] . " - Author: " . $row["author"] . "<br>";
    }
} else {
    echo "0 results";
}

// Close the connection
$conn->close();
?>