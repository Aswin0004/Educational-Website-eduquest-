<?php
include('header.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the teacher ID from the URL
$teacher_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($teacher_id > 0) {
    // Delete the teacher record from the database
    $query = "DELETE FROM teachers WHERE teacher_id = $teacher_id";
    
    if (mysqli_query($conn, $query)) {
        echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
       Teacher deleted successfully.
      </div>';
echo '<script>
        setTimeout(function() {
            window.location.href = "staff.php";
        }, 2000); 
      </script>';
    } else {
        echo "Error deleting teacher: " . mysqli_error($conn);
    }
} else {
    echo "Invalid teacher ID.";
}

mysqli_close($conn);
?>
