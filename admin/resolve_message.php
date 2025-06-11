<?php
$connect = new mysqli("localhost", "root", "", "eduquest");

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

if (isset($_GET['id'])) {
    $messageId = $_GET['id'];

    // Update the status of the message to 'approved' (resolved)
    $query = "UPDATE admin_messages SET status = 'resolved' WHERE id = '$messageId'";

    if ($connect->query($query) === TRUE) {
        // Redirect to the admin messages page after updating
        header("Location: teacher.php"); // Adjust the page URL as needed
        exit();
    } else {
        // If there was an error, display it
        echo "Error updating message: " . $connect->error;
    }
} else {
    // If no ID is passed, show an error message
    echo "No message ID provided.";
}
?>
