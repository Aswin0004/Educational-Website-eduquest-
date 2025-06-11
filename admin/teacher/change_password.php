<?php
session_start();
include('header.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'teacher') {
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
$msg = '';

if (isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password     = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Get the existing password hash
    $stmt = $conn->prepare("SELECT password FROM teachers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Validate current password
    if (password_verify($current_password, $hashed_password)) {
        if ($new_password === $confirm_password) {
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password
            $update = $conn->prepare("UPDATE teachers SET password = ? WHERE email = ?");
            $update->bind_param("ss", $new_hashed_password, $email);

            if ($update->execute()) {
                $msg = "<div class='alert alert-success'>Password updated successfully!</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Error updating password. Try again.</div>";
            }

            $update->close();
        } else {
            $msg = "<div class='alert alert-warning'>New passwords do not match!</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Current password is incorrect!</div>";
    }
}
?>
<div class="container">
<div class="page-inner">
<div class="container mt-5">
    <h3 class="mb-4">Change Password</h3>
    <?php echo $msg; ?>
    <form method="post">
        <div class="form-group mb-3">
            <label>Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>

        <div class="form-group mb-4">
            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>

        <button type="submit" name="update_password" class="btn btn-primary">Update Password</button>
        <a href="teacher.php" class="btn btn-secondary ms-2">Back to Profile</a>
    </form>
</div>
</div>
</div>

<?php include('footer.php'); ?>
