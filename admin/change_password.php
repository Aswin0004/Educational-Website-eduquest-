<?php
include('header.php');
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'staff') {
    header("Location: ../login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['user_email'];

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    $query = "SELECT password FROM staff WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($current_password, $hashed_password)) {
        $message = "<div class='alert alert-danger'>Current password is incorrect.</div>";
    } elseif ($new_password !== $confirm_password) {
        $message = "<div class='alert alert-warning'>New passwords do not match.</div>";
    } else {
        $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE staff SET password = ? WHERE email = ?");
        $update->bind_param("ss", $new_hashed, $email);
        $update->execute();
        $message = "<div class='alert alert-success'>Password changed successfully.</div>";
    }
}
?>
<div class="container">
<div class="page-inner">
<div class="container mt-5">
    <h3>Change Password</h3>
    <?php echo $message; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
        <a href="staff_profile.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
</div>
</div>

<?php include('footer.php'); ?>
