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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $course_id = $_POST['course_id'];
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_option = $_POST['correct_option'];

    // Insert question into database
    $sql = "INSERT INTO questions (course_id, question_text, option_a, option_b, option_c, option_d, correct_option)
            VALUES ('$course_id', '$question_text', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option')";

    if (mysqli_query($conn, $sql)) {
        echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
                    successful.
                 </div>';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>

<div class="container">
    <div class="page-inner">
        <h3 class="fw-bold mb-3">Add Question</h3>
        <form method="POST" action="add_question.php">
            <div class="form-group">
                <label for="course_id">Course:</label>
                <select name="course_id" id="course_id" class="form-control">
                    <?php
                    // Fetch courses from the database
                    $course_query = "SELECT course_id, course_name FROM courses";
                    $course_result = mysqli_query($conn, $course_query);
                    while ($course_row = mysqli_fetch_assoc($course_result)) {
                        echo "<option value='" . $course_row['course_id'] . "'>" . $course_row['course_name'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="question_text">Question Text:</label>
                <textarea name="question_text" id="question_text" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="option_a">Option A:</label>
                <input type="text" name="option_a" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="option_b">Option B:</label>
                <input type="text" name="option_b" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="option_c">Option C:</label>
                <input type="text" name="option_c" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="option_d">Option D:</label>
                <input type="text" name="option_d" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="correct_option">Correct Option:</label>
                <select name="correct_option" id="correct_option" class="form-control" required>
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                    <option value="d">D</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add Question</button>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>
