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
// Get staff ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch staff details
$query = "SELECT * FROM staff WHERE id = $id";
$result = mysqli_query($conn, $query);
$staff = mysqli_fetch_assoc($result);
?>


      
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Admin-Dashboard</h3>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
            <a href="delete_staff.php?id=<?php echo $staff['id']; ?>" class="btn btn-label-info btn-round me-2">Delete</a>

                <a href="edit_staff.php?id=<?php echo $staff['id']; ?>" class="btn btn-primary btn-round">Edit Staff</a>

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
<div class="container py-5">
    <h3 class="mb-4">Staff Full Profile</h3>
    <div class="row">
        <!-- Profile Photo Card -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="uploads/<?php echo htmlspecialchars($staff['photo']); ?>" class="card-img-top" alt="Staff Photo" style="height: 300px; object-fit: cover;">
                <div class="card-body text-center">
                    <h4><?php echo htmlspecialchars($staff['first_name'] . ' ' . $staff['last_name']); ?></h4>
                    <p><?php echo htmlspecialchars($staff['gender']) . ' | ' . date_diff(date_create($staff['dob']), date_create('today'))->y; ?> yrs</p>
                </div>
            </div>
        </div>

        <!-- Details Table -->
        <div class="col-md-8">
            <table class="table table-bordered">
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($staff['email']); ?></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><?php echo htmlspecialchars($staff['phone']); ?></td>
                </tr>
                <tr>
                    <th>Aadhar No</th>
                    <td><?php echo htmlspecialchars($staff['aadhar_number']); ?></td>
                </tr>
                <tr>
                    <th>Place</th>
                    <td><?php echo htmlspecialchars($staff['place']); ?></td>
                </tr>
                <tr>
                    <th>District</th>
                    <td><?php echo htmlspecialchars($staff['district']); ?></td>
                </tr>
                <tr>
                    <th>Pincode</th>
                    <td><?php echo htmlspecialchars($staff['pincode']); ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo nl2br(htmlspecialchars($staff['address'])); ?></td>
                </tr>
                <tr>
                    <th>Certificate</th>
                    <td>
                        <?php if (!empty($staff['certificate'])): ?>
                            <a href="uploads/<?php echo htmlspecialchars($staff['certificate']); ?>" target="_blank">View Certificate</a>
                        <?php else: ?>
                            Not uploaded
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Aadhar File</th>
                    <td>
                        <?php if (!empty($staff['aadhar_file'])): ?>
                            <a href="uploads/<?php echo htmlspecialchars($staff['aadhar_file']); ?>" target="_blank">View Aadhar File</a>
                        <?php else: ?>
                            Not uploaded
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <div class="d-flex justify-content-end">
            <a href="teacher.php" class="btn btn-secondary mt-3">Back to List</a>
            </div>
        </div>
    </div>
</div>


    </div>
</div>


<?php include('footer.php'); ?>







