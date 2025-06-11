<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

$connect = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    // Query to check the OTP and expiry time
    $query = "SELECT * FROM admin WHERE email='$email' AND otp='$otp'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Check if OTP is expired
        if (strtotime($user['otp_expiry']) > time()) {
            // OTP is valid and not expired

            // Unset OTP from the database to ensure it's used only once
            $updateQuery = "UPDATE admin SET otp=NULL, otp_expiry=NULL WHERE email='$email'";
            mysqli_query($conn, $updateQuery);

            // Store user session
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['role'];

            // Redirect to appropriate dashboard
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($user['role'] == 'teacher') {
                header("Location: teacher_dashboard.php");
            } elseif ($user['role'] == 'staff') {
                header("Location: staff_dashboard.php");
            }
        } else {
            echo "OTP expired. Please request a new OTP.";
        }
    } else {
        echo "Invalid OTP!";
    }
}
?>
