<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";  // Use 'localhost' for XAMPP
$username = "root";         // Default XAMPP username is 'root'
$password = "";             // Default XAMPP password is empty
$dbname = "library"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";

// Your other code can go here

?>
