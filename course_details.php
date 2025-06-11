<?php
session_start();
include('header.php');
require_once "db.php";// Include database connection

// Redirect to login page if user not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login/login.php");
    exit();
}
$user_email = $_SESSION['user_email'];

// Get course ID from URL
$course_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch course details
$stmt = $conn->prepare("SELECT * FROM courses WHERE course_id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='container'><p>Course not found.</p></div>";
    include("footer.php");
    exit();
}

$course = $result->fetch_assoc();

?>
<section class="w3l-covers-18">
        <div class="covers-main editContent">
            <div class="container">
                <div class="main-titles-head ">
                    <h3 class="header-name"><?= htmlspecialchars($course['course_name']) ?>
                    </h3>
                    <p class="tiltle-para editContent "><?= htmlspecialchars($course['sub_name']) ?></p>
                </div>
            </div>
        </div>

</section>
<section class="w3l-services-two" id="services">
    <div class="service-single-page editContent">
        <div class="container">
            <div class="service-grids row">
                <!-- Left Image -->
                <div class="col-lg-6">
                    <img src="<?= !empty($course['image']) ? 'admin/' . htmlspecialchars($course['image']) : 'assets/images/default_course.jpg' ?>" 
                         alt="<?= htmlspecialchars($course['course_name']) ?>" 
                         class="img-responsive about-me"
                         style="object-fit: cover; width: 100%; height: auto;">
                </div>

                <!-- Right Text Content -->
                <div class="cwp4-text col-lg-6 text-left pl-lg-5 align-self">
                    <h6 class="small-title">New Course</h6>
                    <h3><?= htmlspecialchars($course['course_name']) ?></h3>

                    <p class="para editContent text">
                        <?= nl2br(htmlspecialchars($course['short_notes'])) ?>
                    </p>

                    <p>
                        <?php if (!empty($course['discounted_price']) && $course['discounted_price'] < $course['price']): ?>
                            <del class="text-info">₹<?= number_format($course['price'], 2) ?></del>
                            <strong class="text-success"> ₹<?= number_format($course['discounted_price'], 2) ?></strong>
                            <span class="text-danger">(<?= $course['discount_percentage'] ?>% OFF)</span>
                        <?php else: ?>
                            ₹<?= number_format($course['price'], 2) ?>
                        <?php endif; ?>
                    </p>

                    <a href="checkout.php?id=<?= $course_id ?>" class="action-button btn mt-lg-5 mt-4">Buy Now</a>
                </div>
            </div>
           
        </div>
    </div>
</section>

<section class="w3l-call-to-action_9">
    <div class="call-w3">
        <div class="container">
            <div class="booking-form-content">
                <div class="main-titles-head">
                    <h3 class="header-name">Requirements</h3>
                </div>

                <div class="row text-center">
                    <?php
                    $icons = ['fa-thumbs-up', 'fa-users', 'fa-pencil', 'fa-book', 'fa-star', 'fa-check', 'fa-graduation-cap', 'fa-laptop']; // Add more icons if needed
                    $requirements = explode("\n", $course['requirements']);
                    foreach ($requirements as $index => $req):
                        $req = trim($req);
                        if ($req === '') continue;
                        $icon = $icons[$index % count($icons)]; // Loop icons if more requirements
                    ?>
                        <div class="col-lg-4 col-md-6 propClone about-line-top">
                            <div class="area-box color-white editContent <?= $index % 2 === 0 ? 'box-active' : '' ?>">
                                <div class="icon-back"><span class="fa <?= $icon ?>"></span></div>

                                <h5><a href="javascript:void(0)" class="editContent">
                                    <?= htmlspecialchars($req) ?>
                                </a></h5>
                                
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="main-titles-head">
                <h3 class="header-name">Full Description</h3></div>
                <p class="tiltle-para editContent">
                        <?= nl2br(htmlspecialchars($course['short_notes'])) ?>
                    </p>
            </div>
        </div>
    </div>
</section>

<?php 

include('footer.php');
?>