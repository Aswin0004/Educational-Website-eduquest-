<?php
include('header.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'teacher') {
    header("Location: ../../teacher_login.php");
    exit;
  }

$conn = new mysqli("localhost", "root", "", "eduquest");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get logged-in teacher's name and email
$email = $_SESSION['user_email'];

// Prepare the SQL query to get the teacher's name by combining first_name and last_name
$stmt = $conn->prepare("SELECT CONCAT(first_name, ' ', last_name) AS teacher_name, email FROM teachers WHERE email = ?");
if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);  // Display the actual error
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $teacher_name = $row['teacher_name'];
    $teacher_email = $row['email'];
} else {
    die("Teacher not found in the database.");
}

// Handle complaint submission
$msg = '';
if (isset($_POST['submit'])) {
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $recipient = $_POST['recipient'];

    $stmt = $conn->prepare("INSERT INTO teacher_complaints (teacher_name, teacher_email, subject, message, recipient) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);  // Display the actual error
    }

    $stmt->bind_param("sssss", $teacher_name, $teacher_email, $subject, $message, $recipient);

    if ($stmt->execute()) {
        $msg = "<div class='alert alert-success'>Complaint submitted successfully.</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Error submitting complaint.</div>";
    }
}
?>
<div class="container">
<div class="page-inner">
<div class="container mt-5">
    <h3>Submit Complaint</h3>

    <?php if (!empty($msg)) echo $msg; ?>

    <form method="post">
        <div class="form-group mb-3">
            <label>Subject</label>
            <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Recipient</label>
            <select name="recipient" class="form-control" required>
                <option value="">-- Select Recipient --</option>
                <option value="admin">Admin</option>
                <option value="subadmin">Sub Admin</option>
            </select>
        </div>

        <div class="form-group mb-4">
            <label>Message</label>
            <textarea name="message" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Send Complaint</button>
        <a href="teacher.php" class="btn btn-secondary ms-2">Back to Profile</a>
    </form>
</div>
</div>
</div>

<?php include('footer.php'); ?>
