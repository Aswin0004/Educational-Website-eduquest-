<?php
$connect = new mysqli("localhost", "root", "", "eduquest");
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipient_type = $_POST['recipient_type'];
    $subject = $connect->real_escape_string($_POST['subject']);
    $message = $connect->real_escape_string($_POST['message']);
    $status = $_POST['status'];

    $sql = "INSERT INTO admin_messages (recipient_type, subject, message, status)
            VALUES ('$recipient_type', '$subject', '$message', '$status')";

    if ($connect->query($sql)) {
        $success = "Message sent successfully!";
    } else {
        $error = "Error: " . $connect->error;
    }
}
?>

<?php include('header.php'); ?>
<div class="container">
    <div class="page-inner"></div>
<div class="container mt-5">
    <h3 class="mb-4">Send Message to Staff/Teacher</h3>

    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="recipient_type" class="form-label">Recipient Type</label>
            <select name="recipient_type" id="recipient_type" class="form-select" required>
                <option value="">Select</option>
                <option value="teacher">Teacher</option>
                <option value="staff">Staff</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
        </div>

        <div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" id="status" class="form-select" disabled>
        <option value="pending" selected>Pending</option>
    </select>
</div>


        <button type="submit" class="btn btn-success">Send Message</button>
    </form>
</div>
</div>
</div>

<?php include('footer.php'); ?>
