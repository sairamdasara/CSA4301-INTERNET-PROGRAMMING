<?php
session_start();
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        // Handle username/password login
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid username or password');</script>";
        }
    } elseif (isset($_POST['request_otp'])) {
        // Handle OTP request
        $email = $_POST['email'];

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            $otp = rand(100000, 999999);
            $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

            $sql = "INSERT INTO otp (user_id, otp, expiry) VALUES ('{$user['id']}', '$otp', '$expiry')";
            mysqli_query($conn, $sql);

            // Send OTP to email (simple example, use mail() or PHPMailer)
            mail($email, "Your OTP Code", "Your OTP code is $otp");

            echo "<script>alert('OTP sent to your email');</script>";
        } else {
            echo "<script>alert('Email not found');</script>";
        }
    }
}
?>