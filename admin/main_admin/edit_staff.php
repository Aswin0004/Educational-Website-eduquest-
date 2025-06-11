<?php
include('header.php');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

// DB connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get staff ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Debug: Output the ID to verify it's being passed correctly
if ($id === 0) {
    echo "<div class='alert alert-danger'>No ID provided in the URL. Please ensure the ID is passed.</div>";
    exit;
}

// Fetch current staff data
$query = "SELECT * FROM staff WHERE id = $id";
$result = mysqli_query($conn, $query);
$staff = mysqli_fetch_assoc($result);

// Debug: Check if the staff data exists
if (!$staff) {
    echo "<div class='alert alert-danger'>Staff not found. Invalid ID?</div>";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $aadhar_number = $_POST['aadhar_number'];
    $place = $_POST['place'];
    $district = $_POST['district'];
    $pincode = $_POST['pincode'];
    $address = $_POST['address'];

    // File upload handling
    $photo = $staff['photo'];
    if (!empty($_FILES['photo']['name'])) {
        $photo = time() . '_' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "../../uploads/$photo");
    }

    $certificate = $staff['certificate'];
    if (!empty($_FILES['certificate']['name'])) {
        $certificate = time() . '_' . $_FILES['certificate']['name'];
        move_uploaded_file($_FILES['certificate']['tmp_name'], "../../uploads/$certificate");
    }

    $aadhar_file = $staff['aadhar_file'];
    if (!empty($_FILES['aadhar_file']['name'])) {
        $aadhar_file = time() . '_' . $_FILES['aadhar_file']['name'];
        move_uploaded_file($_FILES['aadhar_file']['tmp_name'], "../../uploads/$aadhar_file");
    }

    // Update query
    $update = "UPDATE staff SET 
        first_name='$first_name',
        last_name='$last_name',
        gender='$gender',
        dob='$dob',
        email='$email',
        phone='$phone',
        aadhar_number='$aadhar_number',
        place='$place',
        district='$district',
        pincode='$pincode',
        address='$address',
        photo='$photo',
        certificate='$certificate',
        aadhar_file='$aadhar_file'
        WHERE id=$id";

    if (mysqli_query($conn, $update)) {
        echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
        Update successful. Mail sent!
      </div>';
echo '<script>
        setTimeout(function() {
            window.location.href = "staff.php";
        }, 2000); 
      </script>';
    } else {
        echo "<script>alert('Error updating staff.');</script>";
    }
}
?>

<div class="container py-5">
    <h3 class="mb-4">Edit Staff Details</h3>
    <form method="POST" enctype="multipart/form-data" class="card shadow-lg p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="<?php echo isset($staff['first_name']) ? $staff['first_name'] : ''; ?>" required>
            </div>
            <div class="col-md-6">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" value="<?php echo isset($staff['last_name']) ? $staff['last_name'] : ''; ?>" required>
            </div>
            <div class="col-md-6">
                <label>Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="Male" <?php if ($staff['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($staff['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if ($staff['gender'] == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Date of Birth</label>
                <input type="date" name="dob" class="form-control" value="<?php echo isset($staff['dob']) ? $staff['dob'] : ''; ?>" required>
            </div>
            <div class="col-md-6">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo isset($staff['email']) ? $staff['email'] : ''; ?>" required>
            </div>
            <div class="col-md-6">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="<?php echo isset($staff['phone']) ? $staff['phone'] : ''; ?>" required>
            </div>
            <div class="col-md-6">
                <label>Aadhar Number</label>
                <input type="text" name="aadhar_number" class="form-control" value="<?php echo isset($staff['aadhar_number']) ? $staff['aadhar_number'] : ''; ?>" required>
            </div>
            <div class="col-md-6">
                <label>Place</label>
                <input type="text" name="place" class="form-control" value="<?php echo isset($staff['place']) ? $staff['place'] : ''; ?>" required>
            </div>
            <div class="col-md-6">
                <label>District</label>
                <input type="text" name="district" class="form-control" value="<?php echo isset($staff['district']) ? $staff['district'] : ''; ?>" required>
            </div>
            <div class="col-md-6">
                <label>Pincode</label>
                <input type="text" name="pincode" class="form-control" value="<?php echo isset($staff['pincode']) ? $staff['pincode'] : ''; ?>" required>
            </div>
            <div class="col-12">
                <label>Address</label>
                <textarea name="address" class="form-control" rows="3" required><?php echo isset($staff['address']) ? $staff['address'] : ''; ?></textarea>
            </div>
        </div>
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-success">Update Staff</button>           
             <button type="button" onclick="window.location.href='staff.php'" class="btn btn-danger">Cancel</button>

        </div>
    </form>
</div>

<?php include('footer.php'); ?>
