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

// Check if user is logged in as teacher
if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'teacher') {
    header("Location: ../../login/teacher_login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Get department ID of logged-in teacher
$teacherQuery = mysqli_query($conn, "SELECT department FROM teachers WHERE email = '$user_email'");
$department_id = null;
if ($teacherQuery && mysqli_num_rows($teacherQuery) > 0) {
    $row = mysqli_fetch_assoc($teacherQuery);
    $department_id = $row['department'];
}

// Fetch assignments that belong to sections under the teacher's department (course_id)
$query = "
    SELECT 
        a.assignment_id, a.assignment_title, a.assignment_description, a.helping_material,
        s.section_title
    FROM assignments a
    JOIN course_sections s ON a.section_id = s.section_id
    JOIN courses c ON s.course_id = c.course_id
    WHERE c.course_id = '$department_id'
    ORDER BY a.created_at DESC
";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}
?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Assignments</h3>
                <h6 class="op-7 mb-2">All assignments for your department sections</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="add_assignment.php" class="btn btn-primary btn-round">Add New Assignment</a>
            </div>
        </div>

        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['assignment_title']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($row['assignment_description'])) ?></p>
                            <p><strong>Section:</strong> <?= htmlspecialchars($row['section_title']) ?></p>

                            <?php
                            $helping_material = htmlspecialchars($row['helping_material']);
                            if ($helping_material) {
                                $file_extension = pathinfo($helping_material, PATHINFO_EXTENSION);
                                if (in_array(strtolower($file_extension), ['pdf', 'docx', 'pptx'])) {
                                    echo "<p><strong>Supporting Material:</strong> <a href='$helping_material' target='_blank'>Download $file_extension</a></p>";
                                } else {
                                    echo "<p><strong>Supporting Material:</strong> <a href='$helping_material' target='_blank'>View File</a></p>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
