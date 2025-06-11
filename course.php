<?php
session_start();
include('header.php');
require_once "db.php";

// Redirect to login if not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login/login.php");
    exit();
}
$user_email = $_SESSION['user_email'];

// Fetch tags
$sql_tags = "SELECT DISTINCT t.tag_name FROM tags t";
$result_tags = $conn->query($sql_tags);
$tags = [];
if ($result_tags->num_rows > 0) {
    while($row = $result_tags->fetch_assoc()) {
        $tags[] = $row['tag_name'];
    }
}
$unique_tags = array_unique($tags);
sort($unique_tags);

// Filter logic
$tags_filter = '';
if (isset($_GET['tags'])) {
    $selected_tags = $_GET['tags'];
    $tags_filter = " AND c.course_id IN (
        SELECT ct.course_id 
        FROM course_tags ct 
        JOIN tags t ON ct.tag_id = t.tag_id 
        WHERE t.tag_name IN ('" . implode("','", array_map([$conn, 'real_escape_string'], $selected_tags)) . "')
    )";
}
?>
<style>
    .card-img-top {
    width: 100%;
    height: 200px; /* or any desired uniform height */
    object-fit: cover;
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}

    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .tag-item {
        position: relative;
    }

    .tag-checkbox {
        display: none;
    }

    .tag-name {
        display: inline-block;
        padding: 8px 16px;
        background-color: #f1f1f1;
        border-radius: 50px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        color: #333;
    }

    .tag-checkbox:checked + .tag-name {
        background-color: #007bff;
        color: white;
        transform: scale(1.05);
    }

    .tag-name:hover {
        background-color: #f0f0f0;
        transform: scale(1.05);
    }
    .tags-container,
.more-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.more-tags {
    display: none; /* hidden initially */
    margin-top: 0; /* remove extra spacing */
}

    #show-more-btn {
        background: none;
        border: none;
        color: #007bff;
        cursor: pointer;
        font-size: 14px;
        text-decoration: underline;
    }

    #show-more-btn:hover {
        color: #0056b3;
    }
    .card-post {
    display: flex;
    flex-direction: column;
    height: 100%; /* Ensures the card takes up all available space */
}


.card-text {
    max-height: 80px; /* Set the max height of the short notes */
    overflow: hidden; /* Hide overflowing content */
    text-overflow: ellipsis; /* Adds '...' if the content is too long */
}
.card-post {
    display: flex;
    flex-direction: column;
    height: 100%;
    border: 1px solid #000; /* black border */
    border-radius: 0.5rem;
    background-color:rgb(111, 106, 106); /* light gray background */
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
}

.card-post .card-title a {
    color: #007bff; /* Bootstrap blue */
    text-decoration: none;
    font-weight: bold;
}

.card-post .card-title a:hover {
    color: #0056b3; /* darker blue on hover */
    text-decoration: underline;
}

</style>

<section class="w3l-covers-18">
    <div class="covers-main editContent">
        <div class="container">
            <div class="main-titles-head">
                <h3 class="header-name">Browse our top courses</h3>
                <p class="tiltle-para editContent">Lorem ipsum dolor sit amet consectetur...</p>
            </div>

            <!-- Filter by Tags -->
            <div class="filter-section">
                <h5>Filter by Tags</h5>
                <form method="GET" action="">
                    <div class="form-group">
                        <label class="form-label"><strong> Tags:</strong></label>

                        <?php
                        $tags_query = "
                            SELECT DISTINCT t.tag_id, t.tag_name 
                            FROM tags t 
                            INNER JOIN course_tags ct ON t.tag_id = ct.tag_id 
                            INNER JOIN courses c ON c.course_id = ct.course_id
                        ";
                        $tags_result = mysqli_query($conn, $tags_query);

                        $all_tags = [];
                        while ($tag = mysqli_fetch_assoc($tags_result)) {
                            $all_tags[] = $tag;
                        }

                        $first_five_tags = array_slice($all_tags, 0, 5);
                        $remaining_tags = array_slice($all_tags, 5);
                        ?>

                        <div class="tags-container">
                            <?php foreach ($first_five_tags as $tag): 
                                $checked = (isset($_GET['tags']) && in_array($tag['tag_name'], $_GET['tags'])) ? 'checked' : '';
                            ?>
                                <label class="tag-item">
                                    <input 
                                        type="checkbox" 
                                        name="tags[]" 
                                        value="<?= $tag['tag_name'] ?>" 
                                        class="tag-checkbox" 
                                        <?= $checked ?>
                                    />
                                    <span class="tag-name"><?= htmlspecialchars($tag['tag_name']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>

                        <div class="more-tags">
                            <?php foreach ($remaining_tags as $tag): 
                                $checked = (isset($_GET['tags']) && in_array($tag['tag_name'], $_GET['tags'])) ? 'checked' : '';
                            ?>
                                <label class="tag-item">
                                    <input 
                                        type="checkbox" 
                                        name="tags[]" 
                                        value="<?= $tag['tag_name'] ?>" 
                                        class="tag-checkbox" 
                                        <?= $checked ?>
                                    />
                                    <span class="tag-name"><?= htmlspecialchars($tag['tag_name']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>

                        <?php if (count($remaining_tags) > 0): ?>
                            <button type="button" class="btn btn-link" id="show-more-btn">More</button>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2 mt-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="course.php" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>

            <br>

            <!-- Course Display -->
            <div class="gallery-image row">
                <?php
                $sql = "SELECT * FROM courses c WHERE 1=1" . $tags_filter . " ORDER BY course_id DESC";
                if (empty($tags_filter)) {
                    $sql .= " LIMIT 6";
                }

                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                        $imagePath = !empty($row['image']) ? "admin/" . htmlspecialchars($row['image']) : "assets/images/default_course.jpg";
                        $courseName = htmlspecialchars($row['course_name']);
                        $subName = htmlspecialchars($row['sub_name'] ?? '');
                        $price = htmlspecialchars($row['discounted_price'] ?? '');
                        $views = intval($row['views'] ?? 0);
                        $courseDate = isset($row['created_at']) ? date("j M", strtotime($row['created_at'])) : date("j M");
                        $description = htmlspecialchars(substr(strip_tags($row['description']), 0, 100));
                ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <img src="<?= $imagePath ?>" alt="<?= $courseName ?>" class="img-responsive" style="height: 220px; width: 100%; object-fit: cover;">
                        <div class="img-box">
                            <h5 class="mb-2">
                                <a href="course_details.php?id=<?= $row['course_id'] ?>"><?= $courseName ?></a>
                            </h5>
                            <?php if ($subName): ?>
                                <p style="font-size: 14px; color: #fff; margin-top: -10px;"><?= $subName ?></p>
                            <?php endif; ?>
                            <div class="blog-date">
                                <p class="pos-date"><span class="fa fa-calendar mr-1"></span><?= $courseDate ?></p>
                                <p class="pos-date"><strong class="text-success"> ₹ <?= $price ?></strong></p>
                            </div>
                            <p class="para"><?= $description ?>...</p>
                        </div>
                    </div>
                <?php
                    endwhile;
                else:
                    echo "<p class='text-center'>No courses found.</p>";
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('show-more-btn').addEventListener('click', function () {
    var moreTags = document.querySelector('.more-tags');
    var button = this;

    if (moreTags.style.display === 'none' || moreTags.style.display === '') {
        moreTags.style.display = 'flex';
        button.textContent = 'Show Less';
    } else {
        moreTags.style.display = 'none';
        button.textContent = 'More';
    }
});
</script>

<?php include('footer.php'); ?>
