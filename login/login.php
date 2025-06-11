<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

$connect = new mysqli($servername, $username, $password, $dbname);

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password_input = trim($_POST['password']);

    $sql = "SELECT * FROM otp WHERE email = ? AND status = 'verified' ORDER BY otp_send_time DESC LIMIT 1";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check password
        if (password_verify($password_input, $user['password'])) {
            // Login success
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['otp_id'] = $user['id']; // Store user id from otp table


            echo "
            <script>
                alert('Login successful!');
                window.location.href = '../homepage.php'; // or any protected page
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Incorrect password. Please try again.');
                window.location.href = 'login.php';
            </script>
            ";
        }
    } else {
        echo "
        <script>
            alert('No verified user found with that email. Please verify your email first.');
            window.location.href = 'login.php';
        </script>
        ";
    }

    $stmt->close();
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
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



  <div class="form-container">
    <h5>Login-form</h5>

    <!-- Student Form -->
    <div class="form-tab active" id="student-tab">
      <form action="login.php" method="post">
        <div class="mb-3 input-group">
          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
          <input type="text" name="email" class="form-control" placeholder="Student Email" autocomplete="off">
        </div>
        <div class="mb-3 input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off">
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100">Login as Student</button>
      </form>
      
      <br>
      <p>You don't have an account ? <a href="index.php">Register now</a></p>
    </div>

</div>


