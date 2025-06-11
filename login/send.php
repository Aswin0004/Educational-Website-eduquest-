<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

$connect = new mysqli($servername,$username,$password,$dbname);

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST['send'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $otp = $_POST['otp'];

    $ip_address = $_SERVER['REMOTE_ADDR'];

    $sql = "INSERT INTO otp(name,email,phone,password,otp,status,otp_send_time,ip) 
            VALUES ('$name','$email','$phone','$password','$otp','pending',NOW(),'$ip_address')";
    
    if ($connect->query($sql) === TRUE){
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host ='smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username ='eduquest696@gmail.com';
            $mail->Password ='xuhosswpeenzjbyi';
            $mail->SMTPSecure = PHPmailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('eduquest696@gmail.com', 'EduQuest Supporting Team');
            $mail->addAddress ($email);
            $mail->isHTML(true);
            $mail->Subject=$_POST['subject'];
            $mail->Body = "Your OTP Verification code is:" . $otp;


            $mail->send();
            echo "
            <script>
            alert('Verification code has been sent to your email.');
            document.location.href='verify.php';
            </script>";

        } catch(Exception $e) {
            echo "
            <script>
            
            alert('Error : {$mail->ErrorInfo}');
            document.location.href='index.php';
            </script>
            ";
        }
    } else{

        echo "
            <script>
            
            alert('Error inserting data: {$conn->error}');
            document.location.href='index.php';
            </script>
            ";
    }
}
?>