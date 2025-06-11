<?php
session_start();

$connect = new mysqli("localhost", "root", "", "eduquest");

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Default values
$email_value = '';
$password_value = '';

// Step 1: Handle email+password form submission
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email_value = $email;
    $password_value = $password;

    // Check for teacher user
    $stmt = $connect->prepare("SELECT * FROM teachers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Teacher user found
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Valid email & password for teacher
            $_SESSION['logged_in'] = true;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_type'] = 'teacher';  // User type is teacher

            echo "<script>alert('Teacher login successful!'); window.location.href='../admin/teacher/teacher.php';</script>";
            exit();
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
    } else {
        echo "<script>alert('No account found with this email');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Teacher Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
        body{
            background-color: #f0f2f5;
            background-image: url(img/cover.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            height: 62vh;
            margin: 0;
        }
        .form-container{
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
            box-shadow:0 12px 40px rgb(0, 0, 0 / 0.2);
        }

        .form-container h5 {
            text-align: center;
            margin-bottom: 25px;
            color: #343a40;
            border: 2px solid gray;
            border-radius: 10px;
            padding: 5px 10px;
            display: inline-block;
            background-color: #f8f9fa;
            margin-left: 120px;
        }

        .form-control{
            padding-left: 45px;
        }

        .input-group-text{
            width: 40px;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: none;
        }

        .input-group .form-control{
            border-left: none;
        }
    </style>
</head>
<body>
  <div class="form-container">
    <h5>Teacher Login</h5>

    <form action="teacher_login.php" method="post">
        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required value="<?php echo htmlspecialchars($email_value); ?>">
        </div>

        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required value="<?php echo htmlspecialchars($password_value); ?>">
        </div>

        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>

        <a href="staff_login.php">Login as staff</a><br>
        <a href="admin_login.php">Login as Admin</a>
    </form>
  </div>
</body>
</html>
