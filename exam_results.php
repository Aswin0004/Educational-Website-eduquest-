<?php
session_start();
require_once "login/db.php";

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login/login.php");
    exit();
}

$email = $_SESSION['user_email'];
$name = $_SESSION['user_name'] ?? 'User';

include('header.php');

// Get user's courses
$stmt = $conn->prepare("SELECT c.* FROM courses c
    JOIN purchases p ON p.course_id = c.course_id
    WHERE p.user_email = ? AND p.status = 'approved'");
$stmt->bind_param("s", $email);
$stmt->execute();
$courses_result = $stmt->get_result();

// Get user's results
$stmt_results = $conn->prepare("SELECT r.*, c.course_name
    FROM results r
    JOIN courses c ON r.course_id = c.course_id
    WHERE r.user_email = ? ORDER BY r.taken_at DESC");
$stmt_results->bind_param("s", $email);
$stmt_results->execute();
$results = $stmt_results->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Results</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background-color:rgb(0, 0, 0);
        }
        .section-title {
            border-bottom: 2px solid #007bff;
            display: inline-block;
            padding-bottom: 6px;
            margin-bottom: 30px;
        }
        .result-card {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 0 12px rgba(0,0,0,0.05);
            border-left: 5px solid #007bff;
        }
        .result-card h5 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .result-card p {
            margin: 3px 0;
        }
        .status {
            font-weight: bold;
        }
        .status.pass {
            color: green;
        }
        .status.fail {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h2 class="result-card">My Exam Results</h2>
        <div class="row">
            <?php if ($results->num_rows > 0): ?>
                <?php while ($row = $results->fetch_assoc()): ?>
                    <div class="container py-5">
                        <div class="result-card">
                            <h5><?= htmlspecialchars($row['course_name']) ?> - Level <?= htmlspecialchars($row['level']) ?></h5>
                            <p><strong>Date:</strong> <?= date("F j, Y, g:i a", strtotime($row['taken_at'])) ?></p>
                            <p><strong>Score:</strong> <?= $row['final_score'] ?> / <?= $row['total_questions'] ?></p>
                            <p><strong>Percentage:</strong> <?= $row['percentage'] ?>%</p>
                            <p class="status <?= $row['passed'] ? 'pass' : 'fail' ?>">
                                <?= $row['passed'] ? '✅ Passed' : '❌ Failed' ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>No exam results available yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
include('footer.php')
?>