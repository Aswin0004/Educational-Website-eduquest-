<?php
// Database config
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

// Connect to database
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if question_id is passed
if (isset($_GET['question_id'])) {
    $question_id = intval($_GET['question_id']);

    // Delete query
    $sql = "DELETE FROM questions WHERE question_id = $question_id";
    if (mysqli_query($conn, $sql)) {
        // Redirect back to the questions page after deletion
        header("Location: question.php");
        exit();
    } else {
        echo "Error deleting question: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
