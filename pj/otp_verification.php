<?php
session_start();
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify_otp'])) {
    $otp = $_POST['otp'];

    $sql = "SELECT * FROM otp WHERE otp = '$otp' AND expiry > NOW()";
    $result = mysqli_query($conn, $sql);
    $otpRecord = mysqli_fetch_assoc($result);

    if ($otpRecord) {
        // Fetch user and log in
        $userId = $otpRecord['user_id'];

        $_SESSION['user_id'] = $userId;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid or expired OTP');</script>";
    }
}
?>