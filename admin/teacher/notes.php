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

// Check if user is logged in and is a teacher
if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'teacher') {
    header("Location: ../../login/teacher_login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Get the department of the logged-in teacher
$teacherQuery = $conn->query("SELECT department FROM teachers WHERE email = '$user_email'");
$department_id = null;
if ($teacherQuery->num_rows > 0) {
    $teacherRow = $teacherQuery->fetch_assoc();
    $department_id = $teacherRow['department'];
}

// Fetch notes for videos under the same department
$sql = "
    SELECT notes.note_id, notes.note_title, notes.note_file, videos.video_title 
    FROM notes 
    JOIN videos ON notes.video_id = videos.video_id 
    JOIN course_sections ON videos.section_id = course_sections.section_id 
    WHERE course_sections.course_id = '$department_id'
    ORDER BY notes.note_id DESC
";

$result = $conn->query($sql);
?>

<div class="container">
    <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Uploaded Notes</h3>
                <h6 class="op-7 mb-2">All notes added by teachers</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="add_notes.php" class="btn btn-primary btn-round">Add New Note</a>
            </div>
        </div>
        <div class="container mt-5">
            <h2>All Notes</h2>
            <?php if ($result->num_rows > 0): ?>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Video Title</th>
                            <th>Note Title</th>
                            <th>PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($row['video_title']) ?></td>
                                <td><?= htmlspecialchars($row['note_title']) ?></td>
                                <td>
                                    <a href="<?= htmlspecialchars($row['note_file']) ?>" target="_blank" class="btn btn-sm btn-primary">View / Download</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info">No notes found.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>