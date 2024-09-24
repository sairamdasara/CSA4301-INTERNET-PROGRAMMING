<?php
$servername = "localhost"; // Change this to your server name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "surya"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else
{
echo "Connected Successfully";
}
// Check if form is submitted


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $roomno = $_POST['roomno'];
        $floorno = $_POST['floorno'];
        $stmt = $conn->prepare("INSERT INTO registration VALUES (?, ?)");
    $stmt->bind_param("si", $roomno, $floorno);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>