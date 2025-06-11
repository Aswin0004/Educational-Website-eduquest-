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


<section class="w3l-call-to-action_9">
    <div class="call-w3">
        <div class="container">
            <!-- Profile Header -->
            <div class="booking-form-content mb-5">
                <div class="main-titles-head">
                    <h3 class="header-name">Welcome, <?= htmlspecialchars($name) ?></h3>
                    <p class="tiltle-para editContent">
                        <strong>Email:</strong> <?= htmlspecialchars($email) ?>
                    </p>
                </div>
            </div>
</div></div></section>
<style>
    .gallery-image .col-6 {
        display: flex;
        flex-direction: column;
        margin-bottom: 30px;
    }

    .gallery-image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }

    .img-box {
        flex-grow: 1;
        background: #fff;
        padding: 15px;
        border: 1px solid #eee;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .img-box h5 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .img-box .blog-date {
        margin-bottom: 10px;
        font-size: 14px;
        color: #666;
    }

    .img-box .btn {
        width: 100%;
    }

    .img-box .col {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
</style>

<section class="w3l-covers-18">
    <div class="covers-main editContent">
        <div class="container">
            
            <div class="main-titles-head">
                <h3 class="header-name">My Enrolled Courses</h3>
                <p class="tiltle-para editContent">Here are the courses you are currently enrolled in. Continue learning anytime!</p>
            </div>

            <div class="gallery-image row">
                <?php if ($courses_result->num_rows > 0): ?>
                    <?php while ($course = $courses_result->fetch_assoc()): ?>
                        <div class="col-6 top-top">
                            <img src="<?= !empty($course['image']) ? 'admin/' . htmlspecialchars($course['image']) : 'assets/images/default_course.jpg' ?>" alt="Course Image" class="img-responsive">
                            <div class="img-box">
                                <h5 class="mb-2">
                                    <a href="course_materials.php?id=<?= $course['course_id'] ?>">
                                        <?= htmlspecialchars($course['course_name']) ?>
                                    </a>
                                </h5>
                                <div class="blog-date">
                                    <p class="pos-date"> <?= htmlspecialchars($course['sub_name']) ?></p> <!-- You can replace with real data -->
                                </div>
                                <div class="col">
    <a href="course_materials.php?id=<?= $course['course_id'] ?>" class="btn btn-primary btn-sm me-2 mb-2">View Materials</a>
    <a href="exam.php?id=<?= $course['course_id'] ?>" class="btn btn-success btn-sm me-2 mb-2">Take Exam</a>
    <a href="exam_results.php?id=<?= $course['course_id'] ?>" class="btn btn-info btn-sm mb-2">Exam Results</a>
</div>

                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p>You haven't enrolled in any courses yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>




<?php include('footer.php'); ?>