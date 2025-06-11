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

if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'teacher') {
    header("Location: ../../login/teacher_login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Get the teacher's associated department (which references course_id)
$courseOptions = "";
$teacherQuery = $conn->query("SELECT department FROM teachers WHERE email = '$user_email'");
if ($teacherQuery->num_rows > 0) {
    $teacherRow = $teacherQuery->fetch_assoc();
    $department_id = $teacherRow['department'];

    // Fetch the course details from the courses table
    $courseQuery = $conn->query("SELECT course_id, course_name FROM courses WHERE course_id = '$department_id'");
    if ($courseQuery->num_rows > 0) {
        while ($row = $courseQuery->fetch_assoc()) {
            $courseOptions .= "<option value='{$row['course_id']}' selected>{$row['course_name']}</option>";
        }
    }
}

// Handle form submission
if (isset($_POST['submit'])) {
    $course_id = $_POST['course_id'];
    $section_title = mysqli_real_escape_string($conn, $_POST['section_title']);
    $section_description = mysqli_real_escape_string($conn, $_POST['section_description']);

    $sql = "INSERT INTO course_sections (course_id, section_title, section_description)
            VALUES ('$course_id', '$section_title', '$section_description')";

    if ($conn->query($sql) === TRUE) {
        echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
         successful.
      </div>'; echo '<script>
setTimeout(function() {
    window.location.href = "teacher.php";
}, 2000); 
</script>';
    } else {
        echo "<div style='color: red;'>Error: " . $conn->error . "</div>";
    }
}
?>
<div class="container">
<div class="page-inner">

<div class="container mt-5">
    <h2>Add New Course Section</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="course_id">Course</label>
            <select name="course_id" class="form-control" required readonly>
                <?= $courseOptions ?>
            </select>
        </div>

        <div class="form-group">
            <label for="section_title">Section Title</label>
            <input type="text" name="section_title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="section_description">Section Description</label>
            <textarea name="section_description" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add Section</button>
    </form>
</div>
</div>
</div>

<?php
include('footer.php');
?>