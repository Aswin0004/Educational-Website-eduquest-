<?php
// session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
include('header.php');

$type = $_GET['type'] ?? '';
$id = $_GET['id'] ?? '';

$connect = new mysqli("localhost", "root", "", "eduquest");
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$table = "";
$nameField = "";
$emailField = "";

switch ($type) {
    case 'staff':
        $table = 'staff_complaints';
        $nameField = 'staff_name';
        $emailField = 'staff_email';
        break;
    
    default:
        die("Invalid message type.");
}

$query = $connect->query("SELECT * FROM $table WHERE id = '$id'");
if (!$query || $query->num_rows == 0) {
    die("Message not found.");
}

$message = $query->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST['subject'];
    $body = $_POST['message'];
    $to = $message[$emailField];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // your SMTP
        $mail->SMTPAuth = true;
        $mail->Username   = 'eduquest696@gmail.com'; 
        $mail->Password   = 'xuhosswpeenzjbyi';
        $mail->SMTPSecure = PHPmailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('eduquest696@gmail.com', 'Admin - EduQuest');
        $mail->addAddress($to, $message[$nameField]);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br($body);

        $mail->send();
        echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
        Mail sent successful!
      </div>';
echo '<script>
        setTimeout(function() {
            window.location.href = "Help_teacher_desk.php";
        }, 2000); 
      </script>';
        // Optional: update status to 'Replied'
        if ($type !== 'student') {
            $connect->query("UPDATE $table SET status = 'resolved' WHERE id = '$id'");
        }

    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
    }
}
?>
<div class="container">
<div class="page-inner">
<div class="container mt-5">
    <h3>Reply to <?= htmlspecialchars($message[$nameField]) ?></h3>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">To</label>
            <input type="email" class="form-control" value="<?= htmlspecialchars($message[$emailField]) ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" name="subject" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" class="form-control" rows="6" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Reply</button>
    </form>
</div>
</div>
</div>

<?php include('footer.php'); ?>
