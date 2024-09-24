<?php
include 'config.php'; // Ensure this file contains correct database connection details

// Query to select all fines
$sql = "SELECT f.id, u.username, f.amount 
        FROM fines f 
        JOIN users u ON f.user_id = u.id";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Amount</th>
                </tr>";
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["username"] . "</td>
                    <td>" . $row["amount"] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No fines found";
    }
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>