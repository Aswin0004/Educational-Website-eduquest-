<?php
session_start();
require_once "login/db.php";

if (!isset($_SESSION['user_email'])) {
    header("Location: login/login.php");
    exit();
}

$email = $_SESSION['user_email'];
$course_id = $_GET['id'] ?? null;

if (!$course_id) {
    die("Course ID is required.");
}

$stmt = $conn->prepare("SELECT * FROM courses WHERE course_id = ? AND course_id IN (
    SELECT course_id FROM purchases WHERE user_email = ? AND status = 'approved'
)");
$stmt->bind_param("is", $course_id, $email);
$stmt->execute();
$course_result = $stmt->get_result();

if ($course_result->num_rows == 0) {
    die("Course not found or you don't have access to it.");
}

$course = $course_result->fetch_assoc();

include('header.php');

$sections_stmt = $conn->prepare("SELECT * FROM course_sections WHERE course_id = ?");
$sections_stmt->bind_param("i", $course_id);
$sections_stmt->execute();
$sections_result = $sections_stmt->get_result();
?>
<section class="section">
    <br>
    <br>
    <br>
    <div class="container">
        <h3 class="text-center mb-5 text-white">Course Materials for: <?= htmlspecialchars($course['course_name']) ?></h3>
        <div class="row justify-content-center">
            <?php if ($sections_result->num_rows > 0): ?>
                <?php while ($section = $sections_result->fetch_assoc()): ?>
                    <div class="col-lg-10 mb-5">
                        <div class="section-card">
                            <h5 class="section-title text-white"><?= htmlspecialchars($section['section_title']) ?></h5>
                            <p class="section-description text-white"><?= htmlspecialchars($section['section_description']) ?></p>

                            <div class="video-section mb-5">
                                <h6 class="section-heading text-white">Videos</h6>
                                <?php
                                $videos_stmt = $conn->prepare("SELECT * FROM videos WHERE section_id = ?");
                                $videos_stmt->bind_param("i", $section['section_id']);
                                $videos_stmt->execute();
                                $videos_result = $videos_stmt->get_result();

                                if ($videos_result->num_rows > 0):
                                    while ($video = $videos_result->fetch_assoc()):
                                ?>
                                    <div class="video-card mb-4">
                                        <h6 class="video-title text-white"><?= htmlspecialchars($video['video_title']) ?></h6>
                                        <p class="video-description text-white"><?= htmlspecialchars($video['video_description']) ?></p>

                                        <div class="video-player mb-3">
                                            <video width="100%" controls>
                                                <source src="admin/teacher/<?= htmlspecialchars($video['video_url']) ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    </div>
                                <?php endwhile; else: ?>
                                    <p class="text-white">No videos available for this section.</p>
                                <?php endif; ?>
                            </div>

                            <div class="notes-section mb-5">
                                <h6 class="section-heading text-white">Notes</h6>
                                <?php
                                $notes_stmt = $conn->prepare("SELECT * FROM notes WHERE video_id IN (SELECT video_id FROM videos WHERE section_id = ?)");
                                $notes_stmt->bind_param("i", $section['section_id']);
                                $notes_stmt->execute();
                                $notes_result = $notes_stmt->get_result();

                                if ($notes_result->num_rows > 0):
                                    while ($note = $notes_result->fetch_assoc()):
                                ?>
                                    <div class="note-card mb-4">
                                        <h6 class="note-title text-white"><?= htmlspecialchars($note['note_title']) ?></h6>
                                        <div class="note-actions">
                                            <a href="admin/teacher/<?= htmlspecialchars($note['note_file']) ?>" class="btn btn-primary" target="_blank">View</a>
                                            <a href="admin/teacher/<?= htmlspecialchars($note['note_file']) ?>" class="btn btn-secondary" download>Download</a>
                                        </div>
                                    </div>
                                <?php endwhile; else: ?>
                                    <p class="text-white">No notes available for this section.</p>
                                <?php endif; ?>
                            </div>

                            <div class="assignments-section">
                                <h6 class="section-heading text-white">Assignments</h6>
                                <?php
                                $assignments_stmt = $conn->prepare("SELECT * FROM assignments WHERE section_id = ?");
                                $assignments_stmt->bind_param("i", $section['section_id']);
                                $assignments_stmt->execute();
                                $assignments_result = $assignments_stmt->get_result();

                                if ($assignments_result->num_rows > 0):
                                    while ($assignment = $assignments_result->fetch_assoc()):
                                ?>
                                    <div class="assignment-card mb-4">
                                        <h6 class="assignment-title text-white"><?= htmlspecialchars($assignment['assignment_title']) ?></h6>
                                        <p class="assignment-description text-white"><?= htmlspecialchars($assignment['assignment_description']) ?></p>
                                        <div class="assignment-actions">
                                            <a href="admin/teacher/<?= htmlspecialchars($assignment['helping_material']) ?>" class="btn btn-info" target="_blank">Download Material</a>
                                        </div>
                                    </div>
                                <?php endwhile; else: ?>
                                    <p class="text-white">No assignments available for this section.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-white">No sections available for this course.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>