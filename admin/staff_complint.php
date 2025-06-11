<?php
// session_start(); // Start session to access session variables

include('header.php');

// Get the name and email from session
$name = $_SESSION['user_name'] ?? '';  // Use the session value for name
$email = $_SESSION['user_email'] ?? ''; // Use the session value for email
$message = "";

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'staff') {
//     echo "<script>alert('Unauthorized access. Please log in as staff.'); window.location.href='../login.php';</script>";
//     exit();
//   }
  
// Handling the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'] ?? '';
    $body = $_POST['message'] ?? '';
    $recipient = $_POST['recipient'] ?? ''; // Updated field name

    if (!empty($subject) && !empty($body) && !empty($recipient)) {
        // Prepare the query with updated field name
        $stmt = $conn->prepare("INSERT INTO staff_complaints (staff_name, staff_email, subject, message, recipient) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('MySQL prepare error: ' . $conn->error);
        }

        // Bind parameters and execute
        $stmt->bind_param("sssss", $name, $email, $subject, $body, $recipient);
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Complaint submitted successfully.</div>";
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "staff.php";
                    }, 2000); // Redirect after 2 seconds
                  </script>';
        } else {
            $message = "<div class='alert alert-danger'>Error submitting complaint. Please try again.</div>";
        }

        // Close the prepared statement and connection
        $stmt->close();
        $conn->close();

    } else {
        $message = "<div class='alert alert-danger'>Please fill all required fields.</div>";
    }
}
?>

<div class="container">
    <div class="page-inner">
        <div class="container mt-5">
            <h3>Submit a Complaint</h3>
            <?php echo $message; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label>Your Name</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($name); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label>Your Email</label>
                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label>Subject <span class="text-danger">*</span></label>
                    <input type="text" name="subject" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Complaint Message <span class="text-danger">*</span></label>
                    <textarea name="message" class="form-control" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Send Complaint To <span class="text-danger">*</span></label>
                    <select name="recipient" class="form-control" required>
                        <option value="">Select Recipient</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit Complaint</button>
                <a href="staff.php" class="btn btn-secondary ms-2">Back to Profile</a>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
