<?php
include('header.php');

// DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if teacher is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'teacher') {
    header("Location: ../../login/teacher_login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Get teacher ID
$teacherQuery = $conn->query("SELECT teacher_id FROM teachers WHERE email = '$user_email'");
$teacherRow = $teacherQuery->fetch_assoc();
$teacher_id = $teacherRow['teacher_id'];

// Get videos uploaded by this teacher
$videoOptions = "";
$videoQuery = $conn->query("SELECT video_id, video_title FROM videos WHERE uploaded_by = '$teacher_id'");
if ($videoQuery->num_rows > 0) {
    while ($row = $videoQuery->fetch_assoc()) {
        $videoOptions .= "<option value='{$row['video_id']}'>{$row['video_title']}</option>";
    }
} else {
    $videoOptions = "<option disabled>No videos found</option>";
}

// Handle note upload
if (isset($_POST['submit'])) {
    $video_id = $_POST['video_id'];
    $note_title = mysqli_real_escape_string($conn, $_POST['note_title']);

    if (isset($_FILES['note_file']) && $_FILES['note_file']['error'] == 0) {
        $file = $_FILES['note_file'];
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['pdf'];

        if (in_array($file_ext, $allowed_ext)) {
            $upload_dir = "uploads/notes/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $unique_name = time() . '_' . basename($file['name']);
            $target_path = $upload_dir . $unique_name;

            if (move_uploaded_file($file['tmp_name'], $target_path)) {
                // Insert into database
                $sql = "INSERT INTO notes (video_id, note_title, note_file)
                        VALUES ('$video_id', '$note_title', '$target_path')";

                if ($conn->query($sql) === TRUE) {
                    echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
                    successful.
                 </div>';  echo '<script>
                        setTimeout(function() {
                            window.location.href = "teacher.php";
                        }, 2000);
                    </script>';
                } else {
                    echo "<div style='color: red;'>Database error: " . $conn->error . "</div>";
                }
            } else {
                echo "<div style='color: red;'>Failed to upload PDF file.</div>";
            }
        } else {
            echo "<div style='color: red;'>Only PDF files are allowed.</div>";
        }
    } else {
        echo "<div style='color: red;'>No file uploaded or file upload error.</div>";
    }
}
?>

<div class="container">
    <div class="page-inner">
        <div class="container mt-5">
            <h2>Add Note (PDF Upload)</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="video_id">Select Video</label>
                    <select name="video_id" class="form-control" required>
                        <?= $videoOptions ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="note_title">Note Title</label>
                    <input type="text" name="note_title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="note_file">Upload PDF</label>
                    <input type="file" name="note_file" class="form-control" accept=".pdf" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Upload Note</button>
            </form>
        </div>
    </div>
</div>
<?php
include('footer.php');
?>