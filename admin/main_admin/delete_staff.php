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

// Get the staff ID from the URL
$staff_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($staff_id > 0) {
    // Delete the staff record from the database
    $query = "DELETE FROM staff WHERE id = $staff_id";
    
    if (mysqli_query($conn, $query)) {
        echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
        Staff deleted successfullyl. Mail sent!
      </div>';
echo '<script>
        setTimeout(function() {
            window.location.href = "staff.php";
        }, 2000); 
      </script>';// Redirect to the staff list page after deletion
        exit;
    } else {
        echo "Error deleting staff: " . mysqli_error($conn);
    }
} else {
    echo "Invalid staff ID.";
}

mysqli_close($conn);
?>
