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

// Fetch only active teachers
$query = "SELECT teacher_id, first_name, last_name, photo, dob, gender FROM teachers WHERE status = 1";
$result = mysqli_query($conn, $query);
?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Admin-Dashboard</h3>
                <h6 class="op-7 mb-2">Teachers in our institution</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="add_teacher.php" class="btn btn-primary btn-round">Add Teacher</a>
            </div>
        </div>

        <div class="row">
            <?php if (mysqli_num_rows($result) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-sm-6 col-md-3 mb-4 d-flex">
                        <div class="card card-profile w-100 h-100">
                            <div class="card-header" style="background-image: url('assets/img/blogpost.jpg')">
                                <div class="profile-picture">
                                    <div class="avatar avatar-xl">
                                        <img src="uploads/<?php echo htmlspecialchars($row['photo']); ?>" alt="Photo" class="avatar-img rounded-circle" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="user-profile text-center">
                                    <div class="name"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></div>
                                    <div class="job"><?php echo htmlspecialchars($row['gender']); ?>,
                                        <?php
                                        $dob = $row['dob'];
                                        echo $dob ? date_diff(date_create($dob), date_create('today'))->y . " yrs" : "N/A";
                                        ?>
                                    </div>
                                    <div class="desc">Teacher</div>
                                    <div class="view-profile">
                                        <a href="view_teacher.php?id=<?php echo $row['teacher_id']; ?>" class="btn btn-secondary w-100">View Full Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center">No active teachers found.</div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
