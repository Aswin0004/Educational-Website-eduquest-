<?php
session_start();
require_once "login/db.php";

if (!isset($_SESSION['user_email'])) {
    header("Location: login/login.php");
    exit();
}

$email = $_SESSION['user_email'];
$course_id = isset($_POST['course_id']) ? (int)$_POST['course_id'] : null;
$level = isset($_POST['level']) ? (int)$_POST['level'] : null;
$exam_start_time = isset($_SESSION['exam_start_time']) ? $_SESSION['exam_start_time'] : null;

if (!$course_id || !$level || !$exam_start_time) {
    header("Location: profile.php");
    exit();
}

// Timer check
$current_time = time();
$elapsed_time = $current_time - $exam_start_time;
$time_limit = ($level == 1) ? 1800 : (($level == 2) ? 2400 : 3600); // 30, 40, 60 min

if ($elapsed_time > $time_limit || isset($_GET['time_up'])) {
    unset($_SESSION['exam_start_time']);
    header("Location: profile.php");
    exit();
}

// Fetch correct answers
$stmt = $conn->prepare("SELECT question_id, correct_option FROM questions WHERE course_id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

$correct_answers_map = [];
while ($row = $result->fetch_assoc()) {
    $correct_answers_map[$row['question_id']] = $row['correct_option'];
}

$total_questions = count($correct_answers_map);
$correct = 0;
$wrong = 0;
$negative = 0.0;

$user_answers = isset($_POST['answers']) ? $_POST['answers'] : [];

foreach ($correct_answers_map as $question_id => $correct_option) {
    if (isset($user_answers[$question_id])) {
        if ($user_answers[$question_id] === $correct_option) {
            $correct++;
        } else {
            $wrong++;
            $negative += 0.25;
        }
    }
}

// Calculate score and percentage
$score = $correct - $negative;
$percentage = ($total_questions > 0) ? (($score / $total_questions) * 100) : 0;

// Determine pass/fail status based on the exam level
$passing_percentage = ($level == 1) ? 40 : (($level == 2) ? 75 : 75); // Level 1 passes at 40%, Level 2 at 75%

$passed = ($percentage >= $passing_percentage) ? 1 : 0;

// Clear session timer
unset($_SESSION['exam_start_time']);

// Insert result into `results` table
$sql = "INSERT INTO results (user_email, course_id, level, total_questions, correct_answers, wrong_answers, negative_marks, final_score, percentage, passed)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("MySQL prepare error: " . $conn->error);
}

// Ensure correct types
$course_id = (int)$course_id;
$level = (int)$level;
$total_questions = (int)$total_questions;
$correct = (int)$correct;
$wrong = (int)$wrong;
$negative = (float)$negative;
$score = (float)$score;
$percentage = (float)$percentage;
$passed = (int)$passed;

$stmt->bind_param("siiiiddddi", $email, $course_id, $level, $total_questions, $correct, $wrong, $negative, $score, $percentage, $passed);
$stmt->execute();
$stmt->close();
$conn->close();

// Redirect to profile
header("Location: profile.php");
exit();
?>
