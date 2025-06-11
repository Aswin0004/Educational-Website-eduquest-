<?php
// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload PHPMailer (if using Composer)

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


function sendApprovalEmail($staff_email, $staff_name, $subject) {
    // Create instance of PHPMailer
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com'; // your SMTP
            $mail->SMTPAuth = true;
            $mail->Username   = 'eduquest696@gmail.com'; 
            $mail->Password   = 'xuhosswpeenzjbyi';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465; // TCP port for TLS
        // Recipients
        $mail->setFrom('eduquest696@gmail.com', 'Admin'); // Set sender
        $mail->addAddress($staff_email, $staff_name); // Add recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Complaint Approved';
        $mail->Body    = "Dear $staff_name, <br><br>Your complaint with subject '$subject' has been approved.<br><br>Best regards,<br>Admin";

        $mail->send(); // Send the email
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
