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

// Fetch tags from database (only once)
$tags_query = "SELECT * FROM tags";
$tags_result = $connect->query($tags_query);

// Assuming the admin's ID is stored in the session

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
    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Insert course with created_by and created_at fields
    $stmt = $connect->prepare("INSERT INTO courses (course_name, sub_name, price, discounted_price, discount_percentage, image, short_notes, description, requirements, created_by)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddissssi", $course_name, $sub_name, $price, $discounted_price, $discount_percentage, $image, $short_notes, $description, $requirements, $admin_id);
    $stmt->execute();
    $course_id = $stmt->insert_id;

    // Insert tags into course_tags
    foreach ($tags as $tag_id) {
        $stmt2 = $connect->prepare("INSERT INTO course_tags (course_id, tag_id) VALUES (?, ?)");
        $stmt2->bind_param("ii", $course_id, $tag_id);
        $stmt2->execute();
    }
    echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
   Course added successfully!!
  </div>';

echo '<script>
        setTimeout(function() {
            window.location.href = "course.php";
        }, 2000); // Redirect after 2 seconds
      </script>';

}
?>

<!-- Form for adding course -->
<div class="container">
    <div class="page-inner">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Form For New Courses</div>
            </div>
            <form action="add_course.php" method="POST" enctype="multipart/form-data">
            <div class="row">

        <div class="col-sm-6 col-md-4">
          <div class="form-group">
              <label><strong> Name:</strong></label>
              <input class="form-control" type="text" name="course_name" required autocomplete="off" placeholder="Enter course name"/>
          </div>
        </div>
                        
                      <div class="col-sm-6 col-md-4">
        <div class="form-group">
                          <label><strong>Sub Name:</strong></label>
                          <input
                            class="form-control"
                            type="text" name="sub_name" autocomplete="off"
                            placeholder=""
                          />
                        </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label><strong>Price:</strong></label>
                          <div class="input-group mb-3">
                            <span class="input-group-text">₹</span>
                            <input
                              type="number"
                              class="form-control"
                              step="0.01" name="price"
                            />
                            <span class="input-group-text">INR</span>
                          </div>
                        </div>
                        </div>
                    

                        <div class="col-sm-6 col-md-4">
            <div class="form-group">
            <label><strong>Discounted Price:</strong></label>
                          <div class="input-group mb-3">
                            <span class="input-group-text">₹</span>
                            <input
                              class="form-control"
                              type="number" step="0.01" name="discounted_price" id="discounted_price"
                            />
                            <span class="input-group-text">INR</span>
                          </div>
                        </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label><strong>Discount Percentage:</strong></label>
                <div class="input-group mb-3">
                    <input type="number" class="form-control" name="discount_percentage" id="discount_percentage" value="0" />
                            <span class="input-group-text">%</span>
                </div>
            </div>
            </div>
            
                        



            <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label><strong>Image:</strong></label>
                <input type="file" class="form-control-file" name="image"/>
            </div>
            </div>

            <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label><strong>Syllabus:</strong></label>
                <textarea class="form-control" name="short_notes" rows="6">
                </textarea>
            </div>
            </div>

            <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label for="description"><strong>Description:</strong></label>
                <textarea class="form-control" name="description" rows="6">
                </textarea>
            </div>
            </div>
            
            <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <label for="requirements"><strong>Requirements:</strong> <small>(one per line):</small></label><br>
                <textarea class="form-control" name="requirements" id="requirements" rows="6" placeholder="Need a laptop&#10;Need VS Code&#10;Need internet connection" >
                </textarea>
            </div>
            </div>
            <div class="col-XL-4">
            <div class="form-group">
                <label class="form-label"><strong> Tags:</strong></label>
                <div class="selectgroup selectgroup-pills">
                    <?php
                    $tags_query = "SELECT * FROM tags";
                    $tags_result = mysqli_query($connect, $tags_query);
                    while ($tag = mysqli_fetch_assoc($tags_result)) {
                    ?>
                    <label class="selectgroup-item">
                    <input
                        type="checkbox"
                        name="tags[]"
                        value="<?= $tag['tag_id'] ?>"
                        class="selectgroup-input"
                    />
                    <span class="selectgroup-button"><?= htmlspecialchars($tag['tag_name']) ?></span>
                    </label>
                    <?php } ?>
                </div>
            </div>
            </div>

            <div class="card-action">
                    <input type="submit" name="submit" value="Add Course" class="btn btn-success">
                    <button type="button" onclick="window.location.href='course.php'" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
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