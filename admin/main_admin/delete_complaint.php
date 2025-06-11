<?php
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
    // Delete complaint from the database
    $stmt = $conn->prepare("DELETE FROM staff_complaints WHERE id = ?");
    $stmt->bind_param("i", $complaint_id);
    $stmt->execute();

    echo "Complaint deleted successfully.";
}

$conn->close();
?>
