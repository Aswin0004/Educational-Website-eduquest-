<?php
include('header.php');
include('db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    
    $image_name = '';
    if (!empty($_FILES['main_image']['name'])) {
        $image_name = 'uploads/blog_' . time() . '_' . basename($_FILES['main_image']['name']);
        move_uploaded_file($_FILES['main_image']['tmp_name'], $image_name);
    }

    $sql = "INSERT INTO blog (title, content, author, main_image) 
            VALUES ('$title', '$content', '$author', '$image_name')";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Blog post added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>
<div class="container">
<div class="page-inner">
<div class="container mt-5">
    <h3>Add New Blog</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="6" required></textarea>
        </div>

        <div class="mb-3">
            <label>Author</label>
            <input type="text" name="author" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Main Image</label>
            <input type="file" name="main_image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Publish Blog</button>
    </form>
</div>
</div>
</div>
    
    <?php include('footer.php'); ?>
