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

// Check if user is logged in and is a teacher
if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'teacher') {
    header("Location: ../../login/teacher_login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Get teacher's department
$teacherQuery = mysqli_query($conn, "SELECT department FROM teachers WHERE email = '$user_email'");
$department_id = null;
if ($teacherQuery && mysqli_num_rows($teacherQuery) > 0) {
    $row = mysqli_fetch_assoc($teacherQuery);
    $department_id = $row['department'];
}

// Fetch only questions under this department
$query = "
    SELECT 
        q.question_id, q.question_text, q.option_a, q.option_b, q.option_c, q.option_d, q.correct_option,
        c.course_name
    FROM questions q
    JOIN courses c ON q.course_id = c.course_id
    WHERE q.course_id = '$department_id'
    ORDER BY q.question_id DESC
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
                <h3 class="fw-bold mb-3">Questions</h3>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="add_question.php" class="btn btn-primary btn-round">Add New Question</a>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Question</th>
                    <th>Option A</th>
                    <th>Option B</th>
                    <th>Option C</th>
                    <th>Option D</th>
                    <th>Correct Option</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['course_name']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['question_text'])) ?></td>
                        <td><?= htmlspecialchars($row['option_a']) ?></td>
                        <td><?= htmlspecialchars($row['option_b']) ?></td>
                        <td><?= htmlspecialchars($row['option_c']) ?></td>
                        <td><?= htmlspecialchars($row['option_d']) ?></td>
                        <td><?= strtoupper(htmlspecialchars($row['correct_option'])) ?></td>
                        <td>
                            <a href="delete_question.php?question_id=<?= $row['question_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this question?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('footer.php'); ?>
