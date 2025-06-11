<?php
session_start();
include 'mail_function.php';

$connect = new mysqli("localhost", "root", "", "eduquest");
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Default values
$email_value = '';
$password_value = '';
$show_otp_section = false;

// Step 1: Handle email+password form submission
if (isset($_POST['send_otp'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email_value = $email;
    $password_value = $password;

    $stmt = $connect->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Valid email & password
            $otp = rand(100000, 999999);
            $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            $_SESSION['auth_email'] = $email;
            $_SESSION['auth_otp'] = $otp;
            $_SESSION['auth_otp_expiry'] = $otp_expiry;

            if (sendOTP($email, $otp)) {
                $_SESSION['otp_sent'] = true;
                $show_otp_section = true;
            } else {
                echo "<script>alert('Failed to send OTP');</script>";
            }
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
    } else {
        echo "<script>alert('No account found with this email');</script>";
    }
}

// Step 2: Handle OTP verification
// Step 2: Handle OTP verification
if (isset($_POST['verify_otp'])) {
    $entered_otp = $_POST['otp'];
    $original_otp = $_SESSION['auth_otp'] ?? '';
    $otp_expiry = $_SESSION['auth_otp_expiry'] ?? '';
    $email = $_SESSION['auth_email'] ?? '';

    if (!$email || !$original_otp) {
        echo "<script>alert('Session expired. Please login again.'); window.location.href='admin_login.php';</script>";
        exit();
    }

    if ($entered_otp == $original_otp && date('Y-m-d H:i:s') <= $otp_expiry) {
        // OTP matched and not expired
        unset($_SESSION['auth_otp'], $_SESSION['auth_otp_expiry'], $_SESSION['otp_sent']);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $email;

        echo "<script>alert('Login successful!'); window.location.href='../admin/main_admin/admin.php';</script>";
        exit();
    } else {
        // OTP failed — reset flow
        echo "<script>alert('Invalid or expired OTP. Please try again.');</script>";
        unset($_SESSION['otp_sent'], $_SESSION['auth_otp'], $_SESSION['auth_otp_expiry'], $_SESSION['auth_email']);
        $show_otp_section = false;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
        body {
            background-color:rgba(240, 242, 245, 0);
            background-image: url(img/cover.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            height: 62vh;
            margin: 0;
        }
        .form-container {
            max-width: 450px;
            margin: 60px auto;
            padding: 25px;
            background-color: white;
            border-radius: 15px;
            border: 1px solid #ddd;
            box-shadow: 0 6px 20px rgb(0, 0, 0 / 0.1);
            transition: box-shadow 0.3s ease-in-out;
            margin-top: 170px;
            margin-right: 250px;
        }

        .form-container:hover {
            box-shadow: 0 12px 40px rgb(0, 0, 0 / 0.2);
        }

        .form-container h5 {
            text-align: center;
            margin-bottom: 25px;
            color: #343a40;
            border: 2px solid gray;
            border-radius: 10px;
            padding: 5px 10px;
            display: inline-block;
            background-color: rgba(248, 249, 250, 0);
            margin-left: 120px;
        }

        .form-control {
            padding-left: 45px;
        }

        .input-group-text {
            width: 40px;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: none;
        }

        .input-group .form-control {
            border-left: none;
        }
    </style>
</head>
<body>
  <div class="form-container">
    <h5>Admin Login</h5>

    <?php if (isset($_SESSION['otp_sent'])): ?>
      <div class="alert alert-success">OTP sent to your email</div>
    <?php endif; ?>

    <form action="admin_login.php" method="post">
      <?php if (!$show_otp_section): ?>
        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required value="<?php echo htmlspecialchars($email_value); ?>">
        </div>

        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required value="<?php echo htmlspecialchars($password_value); ?>">
        </div>

        <button type="submit" name="send_otp" class="btn btn-primary w-100">Send OTP</button>
      <?php else: ?>
        <div class="mb-3">
          <input type="text" name="otp" class="form-control" placeholder="Enter OTP" required>
        </div>

        <button type="submit" name="verify_otp" class="btn btn-success w-100">Verify & Login</button>
      <?php endif; ?>
      <br><br>
      <a href="staff_login.php">Login as staff</a><br>
      <a href="teacher_login.php">Login as Teacher</a>
    </form>
  </div>
</body>
</html>
