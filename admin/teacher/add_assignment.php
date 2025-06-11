<?php
include('header.php');
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check login and teacher access
if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'teacher') {
    header("Location: ../../login/teacher_login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Get teacher's department
$sectionOptions = "";
$teacherQuery = $conn->query("SELECT teacher_id, department FROM teachers WHERE email = '$user_email'");
if ($teacherQuery->num_rows > 0) {
    $teacherRow = $teacherQuery->fetch_assoc();
    $teacher_id = $teacherRow['teacher_id'];
    $department_id = $teacherRow['department'];

    // Get course sections for the department
    $sectionQuery = $conn->query("SELECT section_id, section_title FROM course_sections WHERE course_id = '$department_id'");
    while ($row = $sectionQuery->fetch_assoc()) {
        $sectionOptions .= "<option value='{$row['section_id']}'>{$row['section_title']}</option>";
    }
}

// Handle form submission
if (isset($_POST['submit'])) {
    $section_id = $_POST['section_id'];
    $assignment_title = mysqli_real_escape_string($conn, $_POST['assignment_title']);
    $assignment_description = mysqli_real_escape_string($conn, $_POST['assignment_description']);
    $upload_dir = 'uploads/';
    $file_path = '';

    if (isset($_FILES['helping_material']) && $_FILES['helping_material']['error'] == 0) {
        $file_name = time() . '_' . basename($_FILES['helping_material']['name']);
        $file_path = $upload_dir . $file_name;

        $allowed_ext = ['pdf', 'doc', 'docx', 'ppt', 'pptx'];
        $file_ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_ext)) {
            if (move_uploaded_file($_FILES['helping_material']['tmp_name'], $file_path)) {
                $sql = "INSERT INTO assignments (section_id, assignment_title, assignment_description, helping_material)
                        VALUES ('$section_id', '$assignment_title', '$assignment_description', '$file_path')";

                if ($conn->query($sql) === TRUE) {
                    echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
         successful.
      </div>'; 
      echo '<script>
                        setTimeout(function() {
                            window.location.href = "teacher.php";
                        }, 2000);
                    </script>';
                } else {
                    echo "<div style='color: red;'>Database Error: " . $conn->error . "</div>";
                }
            } else {
                echo "<div style='color: red;'>Failed to upload file.</div>";
            }
        } else {
            echo "<div style='color: red;'>Invalid file format. Allowed: pdf, doc, docx, ppt, pptx</div>";
        }
    } else {
        echo "<div style='color: red;'>Please upload a file for the assignment.</div>";
    }
}
?>
<div class="container">
<div class="page-inner">
<div class="container mt-5">
    <h2>Add Assignment</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="section_id">Select Course Section</label>
            <select name="section_id" class="form-control" required>
                <?= $sectionOptions ?>
            </select>
        </div>

        <div class="form-group">
            <label for="assignment_title">Assignment Title</label>
            <input type="text" name="assignment_title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="assignment_description">Assignment Description</label>
            <textarea name="assignment_description" class="form-control" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label for="helping_material">Helping Material (PDF, DOCX, etc.)</label>
            <input type="file" name="helping_material" class="form-control" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add Assignment</button>
    </form>
</div>
</div>
</div>
<?php
include('footer.php');
?>