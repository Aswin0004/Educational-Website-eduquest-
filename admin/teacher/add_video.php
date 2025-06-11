<?php
include('header.php');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in and is a teacher
if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'teacher') {
    header("Location: ../../login/teacher_login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Get teacher ID and department (course_id)
$sectionOptions = "";
$teacherQuery = $conn->query("SELECT teacher_id, department FROM teachers WHERE email = '$user_email'");
if ($teacherQuery->num_rows > 0) {
    $teacherRow = $teacherQuery->fetch_assoc();
    $teacher_id = $teacherRow['teacher_id'];
    $department_id = $teacherRow['department'];

    // Fetch course sections under that course (department)
    $sectionQuery = $conn->query("SELECT section_id, section_title FROM course_sections WHERE course_id = '$department_id'");
    if ($sectionQuery->num_rows > 0) {
        while ($row = $sectionQuery->fetch_assoc()) {
            $sectionOptions .= "<option value='{$row['section_id']}'>{$row['section_title']}</option>";
        }
    } else {
        $sectionOptions = "<option disabled>No sections found</option>";
    }
}

// Handle form submission
if (isset($_POST['submit'])) {
    $section_id = $_POST['section_id'];
    $video_title = mysqli_real_escape_string($conn, $_POST['video_title']);
    $video_description = mysqli_real_escape_string($conn, $_POST['video_description']);
    $video_duration = mysqli_real_escape_string($conn, $_POST['video_duration']);

    // Handle file upload
    if (isset($_FILES['video_url']) && $_FILES['video_url']['error'] == 0) {
        $video_file = $_FILES['video_url'];
        
        // Specify the upload directory
        $upload_dir = 'uploads/'; // Ensure there is a trailing slash
        
        // Get file extension and validate
        $file_ext = strtolower(pathinfo($video_file['name'], PATHINFO_EXTENSION));
        
        // You can remove this extension check if you want all types of video files to be accepted.
        // Allowing all video types, no specific extensions needed.
        
        // Generate a unique file name and sanitize it
        $video_name = time() . '.' . $file_ext; 
        $video_path = $upload_dir . basename($video_name); // Ensure the filename is sanitized
        
        // Check if the file size is within limit (e.g., 100MB)
        if ($video_file['size'] <= 104857600) { // 100 MB max size
            // Move the uploaded file to the server's directory
            if (move_uploaded_file($video_file['tmp_name'], $video_path)) {
                // Insert data into the database
                $sql = "INSERT INTO videos (section_id, uploaded_by, video_title, video_description, video_url, video_duration)
                        VALUES ('$section_id', '$teacher_id', '$video_title', '$video_description', '$video_path', '$video_duration')";

                if ($conn->query($sql) === TRUE) {
                    echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
        successful. Mail sent!
      </div>';echo '<script>
                        setTimeout(function() {
                            window.location.href = "teacher.php";
                        }, 2000); 
                    </script>';
                } else {
                    echo "<div style='color: red;'>Error: " . $conn->error . "</div>";
                }
            } else {
                echo "<div style='color: red;'>Error: Failed to upload video file.</div>";
            }
        } else {
            echo "<div style='color: red;'>Error: File size exceeds the maximum limit of 100MB.</div>";
        }
    } else {
        echo "<div style='color: red;'>Error: No video file uploaded or upload error.</div>";
    }
}
?>

<div class="container">
    <div class="page-inner">
        <div class="container mt-5">
            <h2>Add New Video</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="section_id">Course Section</label>
                    <select name="section_id" class="form-control" required>
                        <?= $sectionOptions ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="video_title">Video Title</label>
                    <input type="text" name="video_title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="video_description">Video Description</label>
                    <textarea name="video_description" class="form-control" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label for="video_url">Video</label>
                    <input type="file" name="video_url" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="video_duration">Video Duration (e.g. 12:30)</label>
                    <input type="text" name="video_duration" class="form-control">
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Add Video</button>
            </form>
        </div>
    </div>
</div>
<?php
include('footer.php');
?>