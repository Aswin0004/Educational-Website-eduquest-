<?php

include('header.php');
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function uploadImage($field_name) {
    if (isset($_FILES[$field_name]) && $_FILES[$field_name]['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $filename = basename($_FILES[$field_name]["name"]);
        $target_file = $target_dir . time() . "_" . $filename;
        move_uploaded_file($_FILES[$field_name]["tmp_name"], $target_file);
        return $target_file;
    }
    return NULL;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // First delete the old event
    $conn->query("DELETE FROM events");

    $main_heading = $_POST['main_heading'];
    $event_date = $_POST['event_date'];
    $organized_by = $_POST['organized_by'];
    $description = $_POST['description'];
    $main_guest1 = $_POST['main_guest1'];
    $main_guest2 = $_POST['main_guest2'];

    $main_event_image = uploadImage('main_event_image');
    $sub_image1 = uploadImage('sub_image1');
    $sub_image2 = uploadImage('sub_image2');
    $sub_image3 = uploadImage('sub_image3');
    $guest_images1 = uploadImage('guest_images1');
    $guest_images2 = uploadImage('guest_images2');

    $stmt = $conn->prepare("INSERT INTO events 
        (main_heading, event_date, organized_by, description, main_event_image,
        sub_image1, sub_image2, sub_image3, main_guest1, main_guest2,
        guest_images1, guest_images2)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssss", 
        $main_heading, $event_date, $organized_by, $description,
        $main_event_image, $sub_image1, $sub_image2, $sub_image3,
        $main_guest1, $main_guest2, $guest_images1, $guest_images2
    );

    if ($stmt->execute()) {
        echo "<script>alert('✅ Event added successfully!'); window.location.href='staff.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
}

?>
<div class="container">
<div class="page-inner">
    <div class="container">
        <h2>Add New Event</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3"><input type="text" name="main_heading" class="form-control" placeholder="Main Heading" required></div>
            <div class="mb-3"><input type="date" name="event_date" class="form-control" required></div>
            <div class="mb-3"><input type="text" name="organized_by" class="form-control" placeholder="Organized By" required></div>
            <div class="mb-3"><textarea name="description" class="form-control" placeholder="Event Description"></textarea></div>
            
            <div class="mb-3"><label>Main Event Image</label><input type="file" name="main_event_image" class="form-control"></div>
            <div class="mb-3"><label>Sub Image 1</label><input type="file" name="sub_image1" class="form-control"></div>
            <div class="mb-3"><label>Sub Image 2</label><input type="file" name="sub_image2" class="form-control"></div>
            <div class="mb-3"><label>Sub Image 3</label><input type="file" name="sub_image3" class="form-control"></div>

            <div class="mb-3"><input type="text" name="main_guest1" class="form-control" placeholder="Main Guest 1"></div>
            <div class="mb-3"><input type="text" name="main_guest2" class="form-control" placeholder="Main Guest 2"></div>
            <div class="mb-3"><label>Guest Image 1</label><input type="file" name="guest_images1" class="form-control"></div>
            <div class="mb-3"><label>Guest Image 2</label><input type="file" name="guest_images2" class="form-control"></div>

            <button type="submit" class="btn btn-primary">Submit Event</button>
        </form>
    </div>
    </div>
    </div>


<?php 
include('footer.php');
?>