<?php
include('header.php')
?>

<!-- breadcrumbs -->
<section class="w3l-inner-banner-main">
    <div class="about-inner blog-single editContent">
        <div class="container">   
        <div class="breadcrumbs-sub">
            <ul class="breadcrumbs-custom-path">
                <li class="right-side propClone"><a href="index.html" class="editContent">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
                <li class="active editContent">
                    Contact</li>
            </ul>
            </div>
</div>
</div>
</section>
<!-- breadcrumbs //-->
<section class="w3l-contact-info-main" id="contact">
    <div class="contact-sec	editContent">
        <div class="container">


            <div class="d-grid contact-view">

                <div class="cont-details ">
                    <h3 class="sub-title">Get in touch</h3> 
                    <p class="para mt-3 mb-4">Consectetur adipisicing elit.Lorem ipsum dolor sit amet Dignissimos commodi laborum.</p>
                    
                    <div class="cont-top ">
                        <h6 class="mt-4 cont-left">Address:</h6>
                        <div class="cont-right">
                            <p class="para mt-1"> California, #32841 block,
                                 #221DRS 75<br> West Rock,
                                 Maple Building, UK.</p>
                        </div>
                    </div><div class="cont-top margin-up">
                        <h6 class="mt-4 cont-left">Contact:</h6>
                        <div class="cont-right">
                            <p class="para mt-1"><a href="tel:+44 99 555 42">+123 45 67 89</a></p>
                            <p class="para"><a href="tel:+111 45 67 99">+111 45 67 99</a></p>
                        </div>
                    </div>
                    <div class="cont-top margin-up">
                        <h6 class="mt-4 cont-left">Email:</h6>
                        <div class="cont-right">
                            <p class="para mt-1"><a href="mailto:example@mail.com" class="mail">example@mail.com</a></p>
                        </div>
                    </div>

                </div>
				<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$message = ""; // Message to display to user

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $_POST['name'] ?? '';
    $email   = $_POST['email'] ?? '';
    $phone   = $_POST['phone'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $msg     = $_POST['message'] ?? '';

    if (empty($name) || empty($email) || empty($subject) || empty($msg)) {
        $message = "❌ Required fields are missing.";
    } else {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "eduquest";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            $message = "❌ Database connection failed: " . $conn->connect_error;
        } else {
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $phone, $subject, $msg);

            if ($stmt->execute()) {
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'eduquest696@gmail.com';
                    $mail->Password   = 'xuhosswpeenzjbyi'; // App Password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;

                    $mail->setFrom('eduquest696@gmail.com', 'EduQuest');
                    $mail->addAddress($email, $name);

                    $mail->isHTML(true);
                    $mail->Subject = 'Thank you for contacting EduQuest!';
                    $mail->Body    = "
                        <h2>Hello $name,</h2>
                        <p>Thanks for reaching out to <strong>EduQuest</strong>!</p>
                        <p>We received your message regarding <strong>$subject</strong>.</p>
                        <hr>
                        <p><strong>Your Message:</strong><br>$msg</p>
                        <p>We’ll get back to you soon.<br><br>Warm regards,<br>EduQuest Team</p>
                    ";

                    $mail->send();
                    $message = "✅ Your message has been received. Check your email for confirmation.";
                } catch (Exception $e) {
                    $message = "✅ Message saved. ❌ Email failed to send. Error: {$mail->ErrorInfo}";
                }
            } else {
                $message = "❌ Error saving your message. Please try again.";
            }

            $stmt->close();
            $conn->close();
        }
    }
}
?>





                <div class="map-content-9 pl-lg-5 ">
				<?php if (!empty($message)): ?>
    <div class="alert alert-info" style="margin-bottom: 20px;">
        <?php echo $message; ?>
    </div>
<?php endif; ?>
				<form action="contact.php" method="POST">
                        <div class="twice-two">
						<input type="text" class="form-control" placeholder="Enter your name.." name="name" required autocomplete="off">
						<input type="email" class="form-control" placeholder="Enter email.." name="email" required autocomplete="off">
						<input type="text" class="form-control" placeholder="Your phone.." name="phone" autocomplete="off">
						<input type="text" class="form-control" placeholder="Subject.." name="subject" required autocomplete="off">
                        </div>
                        <textarea class="form-control" placeholder="Message goes here.." name="message" required autocomplete="off"></textarea>
            
                        <div class="text-right">
                            <button type="submit" class="btn btn-contact">Send Message</button>
                        </div>
                    </form>
                </div>








            </div>
                
           
        </div>
    </div>
</section>

<?php
include('footer.php')
?>
