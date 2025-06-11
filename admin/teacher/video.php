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

// Fetch video records along with section title and teacher name
$query = "
    SELECT 
        v.video_id, v.video_title, v.video_description, v.video_url, v.video_duration,
        s.section_title,
        t.first_name AS teacher_fname, t.last_name AS teacher_lname
    FROM videos v
    JOIN course_sections s ON v.section_id = s.section_id
    JOIN teachers t ON v.uploaded_by = t.teacher_id
    ORDER BY v.video_id DESC
";

// Execute query and check if it was successful
$result = mysqli_query($conn, $query);

// Check if query was successful
if (!$result) {
    die("Error executing query: " . mysqli_error($conn));  // Print query error if any
}

?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Uploaded Videos</h3>
                <h6 class="op-7 mb-2">All videos added by teachers</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="add_video.php" class="btn btn-primary btn-round">Add New Video</a>
            </div>
        </div>

        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['video_title']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($row['video_description'])) ?></p>
                            <p><strong>Section:</strong> <?= htmlspecialchars($row['section_title']) ?></p>
                            <p><strong>Uploaded by:</strong> <?= htmlspecialchars($row['teacher_fname'] . ' ' . $row['teacher_lname']) ?></p>
                            <p><strong>Duration:</strong> <?= htmlspecialchars($row['video_duration']) ?></p>

                            <?php
                            $video_url = htmlspecialchars($row['video_url']);
                            if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
                                // Embed YouTube Video
                                parse_str(parse_url($video_url, PHP_URL_QUERY), $ytParams);
                                $videoId = $ytParams['v'] ?? '';
                                if (!$videoId && strpos($video_url, 'youtu.be') !== false) {
                                    $parts = explode("/", parse_url($video_url, PHP_URL_PATH));
                                    $videoId = end($parts);
                                }
                                if ($videoId) {
                                    echo '<div class="ratio ratio-16x9 mb-2">
                                            <iframe src="https://www.youtube.com/embed/' . $videoId . '" frameborder="0" allowfullscreen></iframe>
                                          </div>';
                                }
                            } elseif (pathinfo($video_url, PATHINFO_EXTENSION) === 'mp4') {
                                // Embed MP4 video
                                echo '<video controls width="100%" class="mb-2">
                                        <source src="' . $video_url . '" type="video/mp4">
                                        Your browser does not support the video tag.
                                      </video>';
                            } else {
                                echo "<p><a href=\"$video_url\" target=\"_blank\">Watch Video</a></p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
