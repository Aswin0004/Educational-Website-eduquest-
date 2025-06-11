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

// Fetch available tags
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

// Filter courses based on selected tags
$tags_filter = '';
if (isset($_GET['tags'])) {
    $selected_tags = $_GET['tags'];
    $tags_filter = " AND c.course_id IN (SELECT ct.course_id FROM course_tags ct 
                                         JOIN tags t ON ct.tag_id = t.tag_id
                                         WHERE t.tag_name IN ('" . implode("','", array_map([$conn, 'real_escape_string'], $selected_tags)) . "'))";
}

$sql = "SELECT * FROM courses c WHERE 1=1" . $tags_filter;
$result = $conn->query($sql);
?>
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Staff-Dashboard</h3>
                <h6 class="op-7 mb-2">Courses in over institute</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="add_course.php" class="btn btn-primary btn-round">Add Course</a>
            </div>
        </div>

        <div class="filter-section">
    <h5>Filter by Tags</h5>
    <form method="GET" action="">
        <div class="form-group">
            <label class="form-label"><strong> Tags:</strong></label>

            <?php
            // Run the query only ONCE
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

            // Split into visible and hidden parts
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

            <div class="more-tags" style="display: none;">
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
    </form><br>
</div>


        <!-- Courses display section (same as before) -->
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card card-post card-round">
                            <?php if ($row["image"]): ?>
                                <img class="card-img-top" src="<?= htmlspecialchars($row["image"]) ?>" alt="Course Image" />
                            <?php else: ?>
                                <img class="card-img-top" src="assets/img/default.jpg" alt="Default Course Image" />
                            <?php endif; ?>
                            <div class="card-body">
                                <h3 class="card-title">
                                    <a href="course_details.php?course_id=<?= $row['course_id'] ?>"><?= htmlspecialchars($row["course_name"]) ?></a>
                                </h3>
                                <p class="card-category text-info mb-1">
                                    <?= htmlspecialchars($row["sub_name"]) ?>
                                </p>
                                <p class="card-text">
                                    <?= nl2br(htmlspecialchars($row["short_notes"])) ?>
                                </p>
                                <a href="course_details.php?course_id=<?= $row['course_id'] ?>" class="btn btn-primary btn-rounded btn-sm">Read More</a>
                                <a href="edit_course.php?course_id=<?= $row['course_id'] ?>" class="btn btn-warning btn-rounded btn-sm">Edit Course</a>
                                <div class="separator-solid"></div>
                                <p class="text-muted">Price: $<?= $row["price"] ?> | Discounted Price: $<?= $row["discounted_price"] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No courses available.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

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

<script>
    document.getElementById('show-more-btn').addEventListener('click', function() {
        var moreTags = document.querySelector('.more-tags');
        var tagsContainer = document.querySelector('.tags-container');
        var button = document.getElementById('show-more-btn');

        if (moreTags.style.display === 'none') {
            // Move tags from .more-tags into .tags-container
            while (moreTags.firstChild) {
                tagsContainer.appendChild(moreTags.firstChild);
            }
            moreTags.style.display = 'none'; // keep it hidden now
            button.textContent = 'Show Less';
        } else {
            location.reload(); // Simple way to reset the tags back to original state
        }
    });
</script>

.


<?php
include('footer.php');
?>
