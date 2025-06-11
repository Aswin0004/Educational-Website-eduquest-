<?php
session_start();
require_once "login/db.php";

if (!isset($_SESSION['user_email'])) {
    header("Location: login/login.php");
    exit();
}

$course_id = $_GET['id'] ?? null;

if (!$course_id) {
    echo "Invalid course ID.";
    exit();
}

// Fetch course info
$stmt = $conn->prepare("SELECT * FROM courses WHERE course_id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$course = $stmt->get_result()->fetch_assoc();

if (!$course) {
    echo "Course not found.";
    exit();
}

include('header.php');
?>
<style>
    .color-white {
    height: 100%;
    padding: 20px;
    background: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 10px;
}

</style>
<section class="w3l-recent-work-hobbies" id="services">
    <div class="recent-work editContent">
        <div class="container">

        
            <h3 class="header-name mb-5">Exams for: <?= htmlspecialchars($course['course_name']) ?></h3>
            <div class="row service-service text-center">
                <!-- Level 1: Easy -->
                <div class="col-lg-4 col-md-6 col-sm-6 propClone about-line-top">
                    <div class="color-white editContent">
                        <div class="icon-back"><span class="fa fa-lightbulb-o"></span></div>
                        <h5><a href="start_exam.php?course_id=<?= $course_id ?>&level=1" class="editContent">
                                Level 1 - Easy</a></h5>
                        <p class="para editContent">Basic questions to test your fundamental understanding. Pass with 50% or more.</p>
                        <a href="start_exam.php?course_id=<?= $course_id ?>&level=1" class="btn btn-primary">Start Level 1 Exam</a>
                    </div>
                </div>

                <!-- Level 2: Normal -->
                <div class="col-lg-4 col-md-6 col-sm-6 propClone about-line-top">
                    <div class="color-white editContent">
                        <div class="icon-back"><span class="fa fa-check-square-o"></span></div>
                        <h5><a href="start_exam.php?course_id=<?= $course_id ?>&level=2" class="editContent">
                                Level 2 - Normal</a></h5>
                        <p class="para editContent">Intermediate questions. Requires at least 75% to pass.</p><br>
                        <a href="start_exam.php?course_id=<?= $course_id ?>&level=2" class="btn btn-primary">Start Level 2 Exam</a>
                    </div>
                </div>

                <!-- Level 3: Hard -->
                <div class="col-lg-4 col-md-6 col-sm-6 propClone about-line-top">
                    <div class="color-white editContent">
                        <div class="icon-back"><span class="fa fa-trophy"></span></div>
                        <h5><a href="start_exam.php?course_id=<?= $course_id ?>&level=3" class="editContent" >
                                Level 3 - Hard</a></h5>
                        <p class="para editContent">Advanced questions with negative marking. Pass with 75% correct answers.</p>
                        <a href="start_exam.php?course_id=<?= $course_id ?>&level=3" class="btn btn-primary">Start Level 3 Exam</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><br>

<?php include('footer.php'); ?>
