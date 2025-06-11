<?php
include('header.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$course = null;

if (isset($_GET['course_id'])) {
    $course_id = intval($_GET['course_id']);

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM courses WHERE course_id = ?");
    $stmt->bind_param("i", $course_id); // "i" indicates the type is integer

    // Execute and get the result
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();
    } else {
        $course = null;
    }

    $stmt->close();
}
?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Staff-Dashboard</h3>
                <h6 class="op-7 mb-2">Staff action panel</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                <a href="#" class="btn btn-primary btn-round">Add Customer</a>
            </div>
        </div>
        <div class="container">
            <div class="page-inner">
                <div class="container course-details-container">
                    <?php if ($course): ?>
                        <h1 class="course-title"><?= htmlspecialchars($course['course_name']) ?></h1>
                        
                        <?php if (isset($course['duration'])): ?>
                            <p class="text-muted mb-3"><strong>Duration:</strong> <?= htmlspecialchars($course['duration']) ?></p>
                        <?php else: ?>
                            <p class="text-muted mb-3"><strong>Duration:</strong> Not Available</p>
                        <?php endif; ?>

                        <?php if (!empty($course['tags'])): ?>
                            <div class="mb-3">
                                <?php
                                $tags = explode(',', $course['tags']);
                                if (count($tags) > 0) {
                                    foreach ($tags as $tag) {
                                        echo '<span class="tag">' . htmlspecialchars(trim($tag)) . '</span>';
                                    }
                                } else {
                                    echo '<span>No tags available</span>';
                                }
                                ?>
                            </div>
                        <?php endif; ?>

                        <h5>Description</h5>
                        <p><?= nl2br(htmlspecialchars($course['description'])) ?></p>

                        <?php if (isset($course['instructor'])): ?>
                            <p><strong>Instructor:</strong> <?= htmlspecialchars($course['instructor']) ?></p>
                        <?php endif; ?>

                        <?php if (isset($course['price'])): ?>
                            <p><strong>Price:</strong> ₹<?= htmlspecialchars($course['price']) ?></p>
                        <?php endif; ?>

                        <a href="course.php" class="btn btn-secondary mt-4">← Back to Course List</a>
                    <?php else: ?>
                        <div class="alert alert-warning">Course not found.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>

<style>
    .course-details-container {
        padding: 20px;
    }

    .tag {
        display: inline-block;
        background-color:rgb(255, 0, 208);
        color: white;
        padding: 5px 10px;
        border-radius: 15px;
        margin-right: 5px;
        margin-bottom: 5px;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .course-details-container {
            padding: 10px;
        }

        .course-title {
            font-size: 1.5rem;
        }
    }
</style>
