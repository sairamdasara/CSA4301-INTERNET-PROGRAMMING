<?php
// Include the configuration file
include 'config.php';

// Define a query to test the connection
$sql = "SELECT id, title FROM books"; // Adjust the table name and fields as needed

// Execute the query
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Title: " . $row["title"] . "<br>";
    }
} else {
    echo "0 results";
}

// Close the connection
$conn->close();
?>