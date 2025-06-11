<?php
include('header.php');



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

// Create connection
$conn = mysqli_connect("localhost", "root", "", "eduquest");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Fetch staff records
$query = "SELECT id, first_name, last_name, photo, dob, gender FROM staff";
$result = mysqli_query($conn, $query);
?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Admin-Dashboard</h3>
                <h6 class="op-7 mb-2">Courses in over institute</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="add_staff.php" class="btn btn-primary btn-round">Add Staff</a>
            </div>
        </div>

        <div class="row">
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col-sm-6 col-md-3 mb-4">
                    <div class="card card-profile">
                        <div class="card-header" style="background-image: url('assets/img/blogpost.jpg')">
                            <div class="profile-picture">
                                <div class="avatar avatar-xl">
                                    <img src="uploads/<?php echo $row['photo']; ?>" alt="Photo" class="avatar-img rounded-circle" />
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="user-profile text-center">
                                <div class="name"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></div>
                                <div class="job"><?php echo $row['gender']; ?>, <?php echo date_diff(date_create($row['dob']), date_create('today'))->y; ?> yrs</div>
                                <div class="desc">Staff Member</div>
                                <div class="view-profile">
                                    <a href="view_staff.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary w-100">View Full Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php } else { ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center">No active staff found.</div>
                </div>
            <?php } ?>
            
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
