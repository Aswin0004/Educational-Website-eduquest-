<?php
session_start();
require_once "login/db.php";

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login/login.php");
    exit();
}

// Get course ID and level from query parameters
$course_id = $_GET['course_id'] ?? null;
$level = $_GET['level'] ?? null;

// Ensure course_id and level are valid
if (!$course_id || !$level) {
    echo "Invalid access.";
    exit();
}

// Get the user's email
$email = $_SESSION['user_email'];

// Set a unique session identifier for the timer
if (!isset($_SESSION['exam_start_time'])) {
    $_SESSION['exam_start_time'] = time(); // Set the start time if not set
}

// Fetch random questions for this course (limit to 20)
$stmt = $conn->prepare("SELECT * FROM questions WHERE course_id = ? ORDER BY RAND() LIMIT 20");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$questions = $stmt->get_result();

// Set timer based on the exam level (decreasing timer with higher level)
$exam_timer = 0; // Default timer
switch ($level) {
    case 1:
        $exam_timer = 30 * 60; // 30 minutes for level 1
        break;
    case 2:
        $exam_timer = 20 * 60; // 20 minutes for level 2
        break;
    case 3:
        $exam_timer = 10 * 60; // 10 minutes for level 3
        break;
    default:
        $exam_timer = 30 * 60; // Default 30 minutes if level not recognized
}

// Include header
include('header.php');
?>

<div class="container mt-4" style="display: flex; justify-content: space-between; align-items: flex-start;">
    <div style="flex-grow: 1;">
    <div class="card mb-3 question-card">
    <div class="card-body">
        <h3>Exam - Level <?= $level ?></h3>
        </div>
        </div>
        
        <!-- Display the exam questions here -->
        <form action="exam_submit.php" method="post">
            <input type="hidden" name="course_id" value="<?= $course_id ?>">
            <input type="hidden" name="level" value="<?= $level ?>">

            <?php $qno = 1; ?>
            <?php while ($q = $questions->fetch_assoc()): ?>
                <div class="card mb-3 question-card">
                    <div class="card-body">
                        <h5>Q<?= $qno++ ?>. <?= htmlspecialchars($q['question_text']) ?></h5>

                        <?php foreach (['a', 'b', 'c', 'd'] as $opt): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="answers[<?= $q['question_id'] ?>]" value="<?= $opt ?>" required>
                                <label class="form-check-label">
                                    <?= htmlspecialchars($q["option_$opt"]) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endwhile; ?>

            <button type="submit" class="btn btn-primary">Submit Exam</button>
        </form>
    </div>

    <!-- Timer Section (On the right side) -->
    <div id="timer" class="timer">
        Time Remaining: <span id="timer-countdown"></span><br>
        Answered Questions: <span id="answered-count">0</span>
    </div>
</div>

<?php include('footer.php'); ?>

<script>
    // Get exam start time from session
    let examDuration = <?= $exam_timer ?>; // Total exam duration in seconds
    let startTime = <?= $_SESSION['exam_start_time'] ?? time() ?>; // Start time from session or current time

    let answeredQuestions = 0; // Track answered questions

    // Update timer every second
    function updateTimer() {
        let timeElapsed = Math.floor((new Date().getTime() / 1000) - startTime);
        let timeRemaining = examDuration - timeElapsed;

        if (timeRemaining <= 0) {
            document.getElementById("timer-countdown").innerText = "Time's up!";
            // Optionally, you can disable the submit button or redirect
            // Example: document.querySelector('form').submit();
        } else {
            let minutes = Math.floor(timeRemaining / 60);
            let seconds = timeRemaining % 60;
            document.getElementById("timer-countdown").innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }
    }

    setInterval(updateTimer, 1000); // Update every second

    // Update answered question count
    document.querySelectorAll('input[type="radio"]').forEach(input => {
        input.addEventListener('change', () => {
            // Count how many questions have been answered
            answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
            document.getElementById("answered-count").innerText = answeredQuestions;
        });
    });

    // Sticky Timer Logic (Scrolls with the page)
    window.onscroll = function() {
        var timer = document.getElementById("timer");
        if (window.pageYOffset > 100) {
            timer.style.position = "fixed";
            timer.style.top = "10px";
            timer.style.right = "10px";
            timer.style.zIndex = "999";
        } else {
            timer.style.position = "absolute";
            timer.style.top = "initial";
            timer.style.right = "10px";
        }
    };
</script>

<style>
    .container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-top: 20px;
    }

    .question-card {
        margin-bottom: 15px;
    }

    .timer {
        padding: 20px;
        background-color: #007bff;
        color: white;
        font-size: 24px;
        font-weight: bold;
        border-radius: 8px;
        width: 200px;
        text-align: center;
        position: absolute;
        right: 10px;
        top: 10px;
        z-index: 1000;
    }

    .form-check {
        margin-left: 20px;
    }
</style>
