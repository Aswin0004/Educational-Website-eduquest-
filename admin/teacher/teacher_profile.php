<?php
include('header.php');
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'teacher') {
    header("Location: ../../teacher_login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['user_email'];
$query = "
    SELECT t.*, c.course_name 
    FROM teachers t
    LEFT JOIN courses c ON t.department = c.course_id
    WHERE t.email = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "<div class='alert alert-warning'>Teacher not found.</div>";
    include('footer.php');
    exit;
}

$teacher = $result->fetch_assoc();
$age = $teacher['dob'] ? date_diff(date_create($teacher['dob']), date_create('today'))->y : 'N/A';
?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Teacher Profile</h3>
                <h6 class="op-7 mb-2">Your account information</h6>
            </div>
        </div>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <img src="../main_admin/uploads/<?php echo htmlspecialchars($teacher['photo']); ?>" class="card-img-top" alt="Teacher Photo">
                        <div class="card-body text-center">
                            <h4><?php echo htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']); ?></h4>
                            <p><?php echo htmlspecialchars($teacher['gender']) . ' | ' . $age . ' yrs'; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th>Email</th>
                            <td><?php echo htmlspecialchars($teacher['email']); ?></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><?php echo htmlspecialchars($teacher['phone']); ?></td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td><?php echo htmlspecialchars($teacher['course_name'] ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <th>House Name</th>
                            <td><?php echo htmlspecialchars($teacher['house_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Place</th>
                            <td><?php echo htmlspecialchars($teacher['place']); ?></td>
                        </tr>
                        <tr>
                            <th>District</th>
                            <td><?php echo htmlspecialchars($teacher['district']); ?></td>
                        </tr>
                        <tr>
                            <th>Pincode</th>
                            <td><?php echo htmlspecialchars($teacher['pincode']); ?></td>
                        </tr>
                        <tr>
                            <th>Full Address</th>
                            <td><?php echo nl2br(htmlspecialchars($teacher['address'])); ?></td>
                        </tr>
                        <tr>
                            <th>Certificate</th>
                            <td>
                                <?php if (!empty($teacher['certificate'])): ?>
                                    <a href="../main_admin/uploads/<?php echo htmlspecialchars($teacher['certificate']); ?>" target="_blank">View Certificate</a>
                                <?php else: ?>
                                    Not uploaded
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Aadhar</th>
                            <td>
                                <?php if (!empty($teacher['aadhar_file'])): ?>
                                    <a href="../main_admin/uploads/<?php echo htmlspecialchars($teacher['aadhar_file']); ?>" target="_blank">View Aadhar</a>
                                <?php else: ?>
                                    Not uploaded
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                    <a href="change_password.php" class="btn btn-warning mt-2">Change Password</a>
                    <a href="teacher.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
