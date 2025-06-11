<?php
include('header.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

// Create connection
$connect = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Get course ID from URL
$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : die('Course ID not specified');

// Fetch course details
$course_query = "SELECT * FROM courses WHERE course_id = ?";
$stmt = $connect->prepare($course_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$course_result = $stmt->get_result();
$course = $course_result->fetch_assoc();

// Fetch tags from database
$tags_query = "SELECT * FROM tags";
$tags_result = $connect->query($tags_query);

// Fetch selected tags for the course
$selected_tags_query = "SELECT tag_id FROM course_tags WHERE course_id = ?";
$stmt2 = $connect->prepare($selected_tags_query);
$stmt2->bind_param("i", $course_id);
$stmt2->execute();
$selected_tags_result = $stmt2->get_result();
$selected_tags = [];
while ($row = $selected_tags_result->fetch_assoc()) {
    $selected_tags[] = $row['tag_id'];
}

// Update course details
if (isset($_POST['submit'])) {
    // Sanitize and get values
    $course_name = $_POST['course_name'];
    $sub_name = $_POST['sub_name'];
    $price = $_POST['price'];
    $discounted_price = $_POST['discounted_price'];
    $discount_percentage = $_POST['discount_percentage'];
    $short_notes = $_POST['short_notes'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $tags = $_POST['tags'];

    // Handle image upload
    $image = $course['image']; // keep the existing image if no new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Update course in the database
    $stmt = $connect->prepare("UPDATE courses SET course_name = ?, sub_name = ?, price = ?, discounted_price = ?, discount_percentage = ?, image = ?, short_notes = ?, description = ?, requirements = ? WHERE course_id = ?");
    $stmt->bind_param("ssddisssii", $course_name, $sub_name, $price, $discounted_price, $discount_percentage, $image, $short_notes, $description, $requirements, $course_id);
    $stmt->execute();

    // Update course tags
    $stmt3 = $connect->prepare("DELETE FROM course_tags WHERE course_id = ?");
    $stmt3->bind_param("i", $course_id);
    $stmt3->execute();

    // Insert new tags
    foreach ($tags as $tag_id) {
        $stmt4 = $connect->prepare("INSERT INTO course_tags (course_id, tag_id) VALUES (?, ?)");
        $stmt4->bind_param("ii", $course_id, $tag_id);
        $stmt4->execute();
    }

    echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
    Course update successfully!!
   </div>';
    echo '<script>
            setTimeout(function() {
                window.location.href = "course.php";
            }, 2000); // Redirect after 2 seconds
          </script>';
}
?>

<!-- Form for editing course -->
<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit Course</div>
            </div>
            <form action="edit_course.php?course_id=<?= $course_id ?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label><strong>Name:</strong></label>
                            <input class="form-control" type="text" name="course_name" value="<?= htmlspecialchars($course['course_name']) ?>" required autocomplete="off" placeholder="Enter course name"/>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label><strong>Sub Name:</strong></label>
                            <input class="form-control" type="text" name="sub_name" value="<?= htmlspecialchars($course['sub_name']) ?>" autocomplete="off"/>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label><strong>Price:</strong></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" step="0.01" name="price" value="<?= htmlspecialchars($course['price']) ?>" />
                                <span class="input-group-text">INR</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label><strong>Discounted Price:</strong></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">₹</span>
                                <input class="form-control" type="number" step="0.01" name="discounted_price" value="<?= htmlspecialchars($course['discounted_price']) ?>" />
                                <span class="input-group-text">INR</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label><strong>Discount Percentage:</strong></label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" name="discount_percentage" value="<?= htmlspecialchars($course['discount_percentage']) ?>" />
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label><strong>Image:</strong></label>
                            <input type="file" class="form-control-file" name="image"/>
                            <?php if ($course['image']): ?>
                                <img src="<?= $course['image'] ?>" alt="Course Image" width="100" />
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label><strong>Syllabus:</strong></label>
                            <textarea class="form-control" name="short_notes" rows="6"><?= htmlspecialchars($course['short_notes']) ?></textarea>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label><strong>Description:</strong></label>
                            <textarea class="form-control" name="description" rows="6"><?= htmlspecialchars($course['description']) ?></textarea>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label><strong>Requirements:</strong></label>
                            <textarea class="form-control" name="requirements" rows="6"><?= htmlspecialchars($course['requirements']) ?></textarea>
                        </div>
                    </div>

                    <div class="col-XL-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Tags:</strong></label>
                            <div class="selectgroup selectgroup-pills">
                                <?php while ($tag = mysqli_fetch_assoc($tags_result)): ?>
                                    <label class="selectgroup-item">
                                        <input type="checkbox" name="tags[]" value="<?= $tag['tag_id'] ?>" class="selectgroup-input" <?= in_array($tag['tag_id'], $selected_tags) ? 'checked' : '' ?> />
                                        <span class="selectgroup-button"><?= htmlspecialchars($tag['tag_name']) ?></span>
                                    </label>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>

                    <div class="card-action">
                        <input type="submit" name="submit" value="Update Course" class="btn btn-success">
                        <button type="button" onclick="window.location.href='course.php'" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// JavaScript for handling discount logic (same as in add_course.php)
const priceInput = document.querySelector('input[name="price"]');
const discountedPriceInput = document.querySelector('input[name="discounted_price"]');
const discountPercentageInput = document.querySelector('input[name="discount_percentage"]');

function updatePercentage() {
    const price = parseFloat(priceInput.value);
    const discounted = parseFloat(discountedPriceInput.value);

    if (!isNaN(price) && !isNaN(discounted) && price > 0) {
        const percentage = ((price - discounted) / price) * 100;
        discountPercentageInput.value = Math.round(percentage);
    }
}

function updateDiscountedPrice() {
    const price = parseFloat(priceInput.value);
    const percentage = parseFloat(discountPercentageInput.value);

    if (!isNaN(price) && !isNaN(percentage) && price > 0) {
        const discounted = price - (price * percentage / 100);
        discountedPriceInput.value = discounted.toFixed(2);
    }
}

priceInput.addEventListener('input', () => {
    updatePercentage();
    updateDiscountedPrice();
});

discountedPriceInput.addEventListener('input', updatePercentage);
discountPercentageInput.addEventListener('input', updateDiscountedPrice);
</script>

<?php include('footer.php'); ?>
