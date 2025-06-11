<?php
session_start();
require 'mail.php'; // Include the sendApprovalEmail function

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$complaint_id = $_POST['id'] ?? '';

if ($complaint_id) {
    // Fetch complaint details
    $stmt = $conn->prepare("SELECT * FROM staff_complaints WHERE id = ?");
    $stmt->bind_param("i", $complaint_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $complaint = $result->fetch_assoc();

    if ($complaint) {
        // Send approval email
        sendApprovalEmail($complaint['staff_email'], $complaint['staff_name'], $complaint['subject']);

        // Update status to "Approved"
        $stmt = $conn->prepare("UPDATE staff_complaints SET status = 'Approved' WHERE id = ?");
        $stmt->bind_param("i", $complaint_id);
        $stmt->execute();

        echo "Complaint approved and email sent to the staff.";
    } else {
        echo "Complaint not found.";
    }
}

$conn->close();
?>
