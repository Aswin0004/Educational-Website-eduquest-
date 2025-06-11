<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

$connect = new mysqli($servername, $username, $password, $dbname);

$email = "";
$stored_otp = "";
$message = "";

$ip_address = $_SERVER['REMOTE_ADDR'];

$sql = "SELECT email, otp FROM otp WHERE ip = '$ip_address' AND status = 'pending' ORDER BY otp_send_time DESC";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $stored_otp = $row['otp'];
} else {
    $message = "No pending OTP with this IP.";
}

if (isset($_POST['verify'])) {
    $entered_otp = trim($_POST['otp']);

    if ($entered_otp === $stored_otp) {
        $sql_update = "UPDATE otp SET status = 'verified' WHERE email = '$email' AND ip = '$ip_address'";
        if ($connect->query($sql_update) === TRUE) {
            $message = "Email verified successfully";
            header("Location: success.php");
            exit();
        } else {
            $message = "Error updating OTP status: " . $connect->error;
        }
    } else {
        $message = "Invalid OTP, please try again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <title>Otp verification</title>

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
        <h5>Verify OTP</h5>
        <?php if ($email): ?>

        <div class="alert alert-info" role="alert">

        Your Email is :<strong><?php echo htmlspecialchars($email)?></strong>
        </div>
<?php else: ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $message ?>
        </div>


        <?php endif; ?>
        <form action="" method="post">
            <div class="mb-3 input-group">

            <span class="input-group-text"><i class="fas fa-key"></i></span>
            <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter the otp">
            </div>
            <button type="submit" name="verify" class="btn btn-primary w-100">Verify OTP <i class="fas fa-arrow-right button-icon"></i></button>
        </form>
        <?php if ($message): ?>
    <div class="alert alert-<?php echo ($message === "Email verified successfully") ? "success" : "danger"; ?>" role="alert">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

    </div>
</body>
</html>