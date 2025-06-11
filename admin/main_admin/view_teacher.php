<?php
include('header.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduquest";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>Invalid request. Teacher ID is missing.</div>";
    include('footer.php');
    exit;
}

$teacher_id = intval($_GET['id']);

// Fetch teacher with department name
$query = "SELECT t.*, c.course_name AS department_name 
          FROM teachers t 
          LEFT JOIN courses c ON t.department = c.course_id 
          WHERE t.teacher_id = $teacher_id LIMIT 1";

$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<div class='alert alert-warning'>Teacher not found.</div>";
    include('footer.php');
    exit;
}

$teacher = mysqli_fetch_assoc($result);
$age = $teacher['dob'] ? date_diff(date_create($teacher['dob']), date_create('today'))->y : 'N/A';
?>
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Admin-Dashboard</h3>
                <h6 class="op-7 mb-2">Courses in over institute</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
            <a href="delete_teacher.php?id=<?php echo $teacher['teacher_id']; ?>" class="btn btn-danger">Delete</a>

                <a href="edit_teacher.php?id=<?php echo $teacher['teacher_id']; ?>" class="btn btn-primary btn-round">Edit Teacher</a>

            </div>
        </div>
        <style>
    .container {
        max-width: 1140px;
    }

    h3.fw-bold {
        font-weight: 700;
        color: #2c3e50;
    }

    .card {
        border-radius: 16px;
        overflow: hidden;
        border: none;
        transition: all 0.3s ease;
        background-color:rgb(217, 255, 0);
    }

    .card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    .card-img-top {
        height: 300px;
        object-fit: cover;
        border-bottom: 4px solid #00bcd4;
    }

    .card-body h4 {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .card-body p {
        margin-bottom: 0.25rem;
    }

    .text-muted {
        color:rgb(36, 153, 255) !important;
    }

    .table {
        background-color: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .table th {
        background-color:rgb(221, 138, 138);
        font-weight: 600;
        width: 180px;
    }
    .table td {
        background-color:rgb(221, 138, 138);
        }

    .btn {
        border-radius: 50px;
        padding: 6px 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    @media (max-width: 767px) {
        .card-img-top {
            height: 250px;
        }

        .table th,
        .table td {
            font-size: 14px;
        }

        .d-flex.flex-md-row {
            flex-direction: column;
            text-align: center;
        }

        .ms-md-auto {
            margin-left: 0 !important;
            margin-top: 10px;
        }
    }
</style>

<div class="container mt-4">
    <h3 class="mb-4">Teacher Full Profile</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="uploads/<?php echo htmlspecialchars($teacher['photo']); ?>" class="card-img-top" alt="Teacher Photo">
                <div class="card-body text-center">
                    <h4><?php echo htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']); ?></h4>
                    <p><?php echo htmlspecialchars($teacher['gender']) . ' | ' . $age . ' yrs'; ?></p>
                    <p class="text-muted">Department: <?php echo htmlspecialchars($teacher['department_name'] ?? 'N/A'); ?></p>
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
                    <td><?php echo htmlspecialchars($teacher['phone'] ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <th>House Name</th>
                    <td><?php echo htmlspecialchars($teacher['house_name'] ?? ''); ?></td>
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
                            <a href="uploads/<?php echo htmlspecialchars($teacher['certificate']); ?>" target="_blank">View Certificate</a>
                        <?php else: ?>
                            Not uploaded
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Aadhar</th>
                    <td>
                        <?php if (!empty($teacher['aadhar_file'])): ?>
                            <a href="uploads/<?php echo htmlspecialchars($teacher['aadhar_file']); ?>" target="_blank">View Aadhar</a>
                        <?php else: ?>
                            Not uploaded
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <a href="teacher.php" class="btn btn-secondary mt-3">Back to List</a>
        </div>
    </div>
</div>
    </div>
</div>

<?php include('footer.php'); ?>
