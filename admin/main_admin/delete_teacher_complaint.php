<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM teacher_complaints WHERE id = ?");
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Redirect back to admin page with a success message (optional)
            header("Location: Help_admin_desk.php?msg=deleted");
            exit();
        } else {
            echo "Error deleting complaint: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Failed to prepare the statement.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
