<?php
include('header.php');
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $teacher_id = intval($_GET['id']); // Sanitizing the teacher ID to prevent SQL injection

    // Fetch the teacher's data from the database
    $query = "SELECT * FROM teachers WHERE teacher_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $teacher_id); // 'i' for integer type
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the teacher exists
    if ($teacher = mysqli_fetch_assoc($result)) {
        // Teacher found, now populate the form with their data
    } else {
        echo "Teacher not found!";
        exit();
    }
} else {
    echo "No teacher ID provided!";
    exit();
}

// Handle form submission when the user clicks "Save Changes"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize the form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $house_name = mysqli_real_escape_string($conn, $_POST['house_name']);
    $place = mysqli_real_escape_string($conn, $_POST['place']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $status = $_POST['status'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $aadhar_number = mysqli_real_escape_string($conn, $_POST['aadhar_number']); // New Aadhar Number field
    
    // Prepare the update query
    $update_query = "UPDATE teachers SET 
                        first_name = ?, 
                        last_name = ?, 
                        gender = ?, 
                        dob = ?, 
                        email = ?, 
                        phone = ?, 
                        house_name = ?, 
                        place = ?, 
                        district = ?, 
                        pincode = ?, 
                        status = ?, 
                        address = ?, 
                        aadhar_number = ? 
                    WHERE teacher_id = ?";
    
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $update_query);
    
    // Bind parameters and execute the update
    mysqli_stmt_bind_param($stmt, "ssssssssssissi", 
        $first_name, $last_name, $gender, $dob, $email, $phone, $house_name, 
        $place, $district, $pincode, $status, $address, $aadhar_number, $teacher_id);
    
    // Execute the query and check for success
    if (mysqli_stmt_execute($stmt)) {
        echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
        Teacher updated successfully!
      </div>';
echo '<script>
        setTimeout(function() {
            window.location.href = "staff.php";
        }, 2000); 
      </script>';
    } else {
        echo "Error updating teacher: " . mysqli_error($conn);
    }
}
?>

<div class="container py-5">
    <h3 class="mb-4">Edit Teacher Details</h3>
    <form method="POST" class="card shadow p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="<?php echo $teacher['first_name']; ?>" required>
            </div>
            <div class="col-md-6">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" value="<?php echo $teacher['last_name']; ?>" required>
            </div>
            <div class="col-md-6">
                <label>Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="Male" <?php if ($teacher['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($teacher['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if ($teacher['gender'] == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Date of Birth</label>
                <input type="date" name="dob" class="form-control" value="<?php echo $teacher['dob']; ?>" required>
            </div>
            <div class="col-md-6">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $teacher['email']; ?>" required>
            </div>
            <div class="col-md-6">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $teacher['phone']; ?>">
            </div>
            <div class="col-md-6">
                <label>House Name</label>
                <input type="text" name="house_name" class="form-control" value="<?php echo $teacher['house_name']; ?>">
            </div>
            <div class="col-md-6">
                <label>Place</label>
                <input type="text" name="place" class="form-control" value="<?php echo $teacher['place']; ?>">
            </div>
            <div class="col-md-6">
                <label>District</label>
                <input type="text" name="district" class="form-control" value="<?php echo $teacher['district']; ?>">
            </div>
            <div class="col-md-6">
                <label>Pincode</label>
                <input type="text" name="pincode" class="form-control" value="<?php echo $teacher['pincode']; ?>">
            </div>
            <div class="col-md-6">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="1" <?php echo ($teacher['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                    <option value="0" <?php echo ($teacher['status'] == 0) ? 'selected' : ''; ?>>Dismissed</option>
                </select>
            </div>
             <!-- Aadhar Number Field -->
             <div class="col-md-6">
                <label>Aadhar Number</label>
                <input type="text" name="aadhar_number" class="form-control" value="<?php echo $teacher['aadhar_number']; ?>" required>
            </div>

            <div class="col-md-12">
                <label>Address</label>
                <textarea name="address" rows="3" class="form-control"><?php echo $teacher['address']; ?></textarea>
            </div>
            
           
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <button type="button" onclick="window.location.href='teacher.php'" class="btn btn-danger">Cancel</button>
            </div>
        </div>
    </form>
</div>

<?php include('footer.php'); ?>
