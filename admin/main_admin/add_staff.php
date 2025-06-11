<?php

include('header.php');

?>


<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // DB connection
    $conn = new mysqli("localhost", "root", "", "eduquest");
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    // Collect form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $house_name = $_POST['house_name'];
    $place = $_POST['place'];
    $district = $_POST['district'];
    $pincode = $_POST['pincode'];
    $address = $_POST['address'];
    $aadhar_number = $_POST['aadhar_number'];
    $password = password_hash($aadhar_number, PASSWORD_DEFAULT); // default password
    $certificate = $_FILES['certificate']['name'];
    $aadhar_file = $_FILES['aadhar_file']['name'];
    $photo = $_FILES['photo']['name'];

    // Upload files
    move_uploaded_file($_FILES['certificate']['tmp_name'], "uploads/".$certificate);
    move_uploaded_file($_FILES['aadhar_file']['tmp_name'], "uploads/".$aadhar_file);
    move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/".$photo);

    // Save in DB
    $sql = "INSERT INTO staff (first_name, last_name, email, phone, gender, dob, house_name, place, district, pincode, address, certificate, aadhar_number, aadhar_file, photo, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssss", $first_name, $last_name, $email, $phone, $gender, $dob, $house_name, $place, $district, $pincode, $address, $certificate, $aadhar_number, $aadhar_file, $photo, $password);

    if ($stmt->execute()) {
        // Email sending
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // your SMTP
            $mail->SMTPAuth = true;
            $mail->Username   = 'eduquest696@gmail.com'; 
            $mail->Password   = 'xuhosswpeenzjbyi';
            $mail->SMTPSecure = PHPmailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('eduquest696@gmail.com', 'EduQuest Admin');
            $mail->addAddress($email);
            $mail->Subject = 'Welcome to EduQuest!';
            $mail->Body    = "You are registered successfully.\n\nYour password is now aadhar number\n\nPlease change your password as soon as possible.\nWelcome to EduQuest!";

            $mail->send();
            echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
        Registration successful. Mail sent!
      </div>';
echo '<script>
        setTimeout(function() {
            window.location.href = "staff.php";
        }, 2000); 
      </script>';
           
        } catch (Exception $e) {
            echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
        Mail could not be sent. Error: ' . htmlspecialchars($mail->ErrorInfo) . '
      </div>';

        }
    } else {
        
        echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
        Error: ' . htmlspecialchars($stmt->error) . '
      </div>';

    }
    $conn->close();
}
?>
<!-- Form for adding course -->
<div class="container">
    <div class="page-inner">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Form For Register staff</div>
            </div>
            <form method="post" enctype="multipart/form-data">
            <div class="row">
<!-- HTML form -->
        <div class="col-sm-6 col-md-4">
          <div class="form-group">
              <label><strong> Name:</strong></label>
              <input class="form-control" type="text" name="first_name" placeholder="First Name" required autocomplete="off" />
          </div>
        </div>

        <div class="col-sm-6 col-md-4">
          <div class="form-group">
              <label><strong> Last name:</strong></label>
              <input class="form-control" type="text" name="last_name" placeholder="Last Name" required autocomplete="off" />
          </div>
        </div>
        
        <div class="col-sm-6 col-md-4">
          <div class="form-group">
              <label><strong> Email:</strong></label>
              <input class="form-control" type="email" name="email" placeholder="Email" required autocomplete="off" />
          </div>
        </div>

        <div class="col-sm-6 col-md-4">
          <div class="form-group">
              <label><strong> Phone:</strong></label>
              <input class="form-control" type="text" name="phone" placeholder="Phone" required autocomplete="off" />
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
  <div class="form-group">
    <label>Gender</label><br />
    <div class="d-flex gap-4">
      <div class="form-check">
        <input
          class="form-check-input"
          type="radio"
          name="gender"
          id="genderMale"
          value="Male"
          required
        />
        <label class="form-check-label" for="genderMale">Male</label>
      </div>
      <div class="form-check">
        <input
          class="form-check-input"
          type="radio"
          name="gender"
          id="genderFemale"
          value="Female"
        />
        <label class="form-check-label" for="genderFemale">Female</label>
      </div>
      <div class="form-check">
        <input
          class="form-check-input"
          type="radio"
          name="gender"
          id="genderOther"
          value="Other"
        />
        <label class="form-check-label" for="genderOther">Other</label>
      </div>
    </div>
  </div>
</div>

<div class="col-sm-6 col-md-4">
  <div class="form-group">
    <label for="dob">Date of Birth</label>
    <input
      type="date"
      name="dob"
      id="dob"
      class="form-control"
      required
    />
  </div>
</div>

<div class="card-header">
                <div class="card-title">Address details</div>
            </div>
            <div class="col-sm-6 col-md-4">
  <div class="form-group">
    <label for="house_name">House Name</label>
    <input
      type="text"
      name="house_name"
      id="house_name"
      class="form-control"
      placeholder="Enter House Name"
      required
    />
  </div>
</div>
<div class="col-sm-6 col-md-4">
          <div class="form-group">
              <label><strong> Place:</strong></label>
              <input class="form-control" type="text" name="place" placeholder="Place" required autocomplete="off" />
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-group">
              <label><strong> District:</strong></label>
              <input class="form-control" type="text" name="district" placeholder="District" required autocomplete="off" />
          </div>
        </div><div class="col-sm-6 col-md-4">
          <div class="form-group">
              <label><strong> Pincode:</strong></label>
              <input class="form-control" type="text" name="pincode" placeholder="Pincode" required autocomplete="off" />
          </div>
        </div>
        
        <div class="col-sm-6 col-md-4">
         <div class="form-group">
                          <label for="largeInput">Address:</label>
                          <input
                            type="text"
                            class="form-control form-control-lg"
                            name="address" placeholder="Address" autocomplete="off" 
                          />
                        </div>
        </div>
        

        <div class="col-sm-6 col-md-4">
          <div class="form-group">
              <label><strong> Aadhar number:</strong></label>
              <input class="form-control" type="text" name="aadhar_number" placeholder="Aadhar Number" required autocomplete="off" />
          </div>
        </div>

        <div class="card-header">
                <div class="card-title">Upload Document</div>
            </div>

            <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label><strong>Certificate:</strong></label>
                <input type="file" class="form-control-file"name="certificate" required/>
            </div>
            </div>
    <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label><strong>Aadhar File:</strong></label>
                <input type="file" class="form-control-file" name="aadhar_file" required/>
            </div>
            </div>
    <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label><strong>Photo:</strong></label>
                <input type="file" class="form-control-file" name="photo" required/>
            </div>
            </div>

            <div class="card-action">
                    <input type="submit" name="submit" value="Register Staff" class="btn btn-success">
                </div>
</form>

        </div>
    </div>
    </div>
</div>
<?php
include("footer.php");

?>