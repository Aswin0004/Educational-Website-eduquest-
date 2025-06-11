<?php

include('header.php');
// Include the database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

// Include PHPMailer files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// DB connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch available departments from the courses table for dropdown
$departments_query = "SELECT course_id, course_name FROM courses";
$departments_result = mysqli_query($conn, $departments_query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $house_name = $_POST['house_name'];
    $place = $_POST['place'];
    $district = $_POST['district'];
    $pincode = $_POST['pincode'];
    $status = 1; // Teacher is active by default
    $address = $house_name . ', ' . $place . ', ' . $district . ', ' . $pincode;
    
    // Set the Aadhaar number as the default password
    $aadhar_number = $_POST['aadhar_number']; // Receiving the Aadhaar number as part of the form

    // Hash the password before storing it (you may want to reconsider this approach for security reasons)
    $hashed_password = password_hash($aadhar_number, PASSWORD_DEFAULT);

    // File upload handling for photo, certificate, and aadhar file
    $photo = '';
    if (!empty($_FILES['photo']['name'])) {
        $photo = time() . '_' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/$photo");
    }

    $certificate = '';
    if (!empty($_FILES['certificate']['name'])) {
        $certificate = time() . '_' . $_FILES['certificate']['name'];
        move_uploaded_file($_FILES['certificate']['tmp_name'], "uploads/$certificate");
    }

    $aadhar_file = '';
    if (!empty($_FILES['aadhar_file']['name'])) {
        $aadhar_file = time() . '_' . $_FILES['aadhar_file']['name'];
        move_uploaded_file($_FILES['aadhar_file']['tmp_name'], "uploads/$aadhar_file");
    }

    // Insert query to add the new teacher into the database
    $insert_query = "INSERT INTO teachers (first_name, last_name, gender, dob, email, phone, department, house_name, place, district, pincode, status, photo, certificate, aadhar_file, address, aadhar_number, password)
                     VALUES ('$first_name', '$last_name', '$gender', '$dob', '$email', '$phone', '$department', '$house_name', '$place', '$district', '$pincode', '$status', '$photo', '$certificate', '$aadhar_file', '$address', '$aadhar_number', '$hashed_password')";

    if (mysqli_query($conn, $insert_query)) {
        // Send email to the teacher using PHPMailer
        $subject = "Teacher Assignment and Password Information";
        $message = "Dear $first_name $last_name,\n\n" .
                   "You have been successfully assigned to the $department department.\n" .
                   "Your default password is your Aadhaar number: $aadhar_number.\n" .
                   "Please change your password immediately upon logging in.\n\n" .
                   "Best regards,\nEduQuest Team";

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // your SMTP
            $mail->SMTPAuth = true;
            $mail->Username   = 'eduquest696@gmail.com'; 
            $mail->Password   = 'xuhosswpeenzjbyi';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465; // TCP port for TLS

            //Recipients
            $mail->setFrom('eduquest696@gmail.com', 'EduQuest');
            $mail->addAddress($email, "$first_name $last_name");  // Add the recipient's email address

            //Content
            $mail->isHTML(false);  // Set email format to plain text
            $mail->Subject = $subject;
            $mail->Body    = $message;

            // Send the email
            $mail->send();

            echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
            Registration successful. Mail sent!
          </div>';
          
echo '<script>
setTimeout(function() {
    window.location.href = "teacher.php";
}, 2000); 
</script>';
        } catch (Exception $e) {
            echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
            Mail could not be sent. Error: ' . htmlspecialchars($mail->ErrorInfo) . '
          </div>';
        }
    } else {
        echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
        Error adding teacher.
      </div>';
    }
}

mysqli_close($conn);
?>
<div class="container">
<div class="page-inner">
<!-- Add Teacher Form HTML here as it is in your original page -->
<div class="container py-5">
    <h3 class="mb-4">Add Teacher</h3>
    <form method="POST" enctype="multipart/form-data" class="card shadow-lg p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Date of Birth</label>
                <input type="date" name="dob" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Department</label>
                <select name="department" class="form-control" required>
                    <option value="">Select Department</option>
                    <?php while ($row = mysqli_fetch_assoc($departments_result)) { ?>
                        <option value="<?php echo $row['course_id']; ?>"><?php echo $row['course_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6">
                <label>House Name</label>
                <input type="text" name="house_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Place</label>
                <input type="text" name="place" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>District</label>
                <input type="text" name="district" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Pincode</label>
                <input type="text" name="pincode" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Aadhaar Number</label>
                <input type="text" name="aadhar_number" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Photo</label><br>
                <input type="file" name="photo" class="form-control mt-1">
            </div>
            <div class="col-md-4">
                <label>Certificate</label><br>
                <input type="file" name="certificate" class="form-control mt-1">
            </div>
            <div class="col-md-4">
                <label>Aadhar File</label><br>
                <input type="file" name="aadhar_file" class="form-control mt-1">
            </div>
        </div>
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-success">Add Teacher</button>
            <button type="button" onclick="window.location.href='teacher.php'" class="btn btn-danger">Cancel</button>
        </div>
    </form>
</div>
</div>


<?php include('footer.php'); ?>
