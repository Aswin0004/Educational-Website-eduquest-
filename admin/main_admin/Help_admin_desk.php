<?php include('header.php'); ?>

<div class="container">
<div class="page-inner">
<div class="container mt-5">
<h3 class="fw-bold mb-4">Help Desk</h3>
<?php
$connect = new mysqli("localhost", "root", "", "eduquest");
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
?>

<!-- Staff Complaints -->
<div class="mb-5">
    <h5 class="mb-3">Messages from Staff</h5>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Staff Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Received</th>
                    <th>Reply</th>
                    <th>Delete</th>
                    <th>Approve</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $staffResult = $connect->query("SELECT * FROM staff_complaints WHERE recipient = 'admin' AND status = 'pending' ORDER BY submitted_at DESC");

                if ($staffResult && $staffResult->num_rows > 0):
                    $count = 1;
                    while ($row = $staffResult->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= htmlspecialchars($row['staff_name']) ?></td>
                    <td><?= htmlspecialchars($row['staff_email']) ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                    <td><span class="badge bg-warning text-dark"><?= htmlspecialchars($row['status']) ?></span></td>
                    <td><?= date('d M Y', strtotime($row['submitted_at'])) ?></td>
                    <td><a href="reply_message.php?type=staff&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Reply</a></td>
                    <td><a href="delete_staff_complaint.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this complaint?');">Delete</a></td>
                    <td>
    <a href="mark_complete.php?type=staff&id=<?= $row['id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Mark as completed?');">Complete</a>
</td>

                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="9" class="text-center">No staff complaints found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Teacher Complaints -->
<div class="mb-5">
    <h5 class="mb-3">Messages from Teachers</h5>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Teacher Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Received</th>
                    <th>Reply</th>
                    <th>Delete</th>
                    <th>Approve</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $teacherResult = $connect->query("SELECT * FROM teacher_complaints WHERE recipient = 'admin' AND status = 'pending' ORDER BY submitted_at DESC");

                if ($teacherResult && $teacherResult->num_rows > 0):
                    $count = 1;
                    while ($row = $teacherResult->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= htmlspecialchars($row['teacher_name']) ?></td>
                    <td><?= htmlspecialchars($row['teacher_email']) ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                    <td><span class="badge bg-warning text-dark"><?= htmlspecialchars($row['status']) ?></span></td>
                    <td><?= date('d M Y', strtotime($row['submitted_at'])) ?></td>
                    <td><a href="reply_message.php?type=teacher&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Reply</a></td>
                    <td><a href="delete_teacher_complaint.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this complaint?');">Delete</a></td>
                    <td>
    <a href="mark_complete.php?type=teacher&id=<?= $row['id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Mark as completed?');">Complete</a>
</td>

                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="9" class="text-center">No teacher complaints found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Student Contact Messages -->
<div class="mb-5">
    <h5 class="mb-3">Messages from Not Login Students</h5>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Received</th>
                    <th>Reply</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $connect->query("SELECT * FROM contact_messages ORDER BY id DESC");
                if ($result && $result->num_rows > 0):
                    $count = 1;
                    while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                    <td><?= date('d M Y', strtotime($row['created_at'] ?? 'now')) ?></td>
                    <td><a href="reply_message.php?type=student&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Reply</a></td>
                    <td><a href="delete_message.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this message?');">Delete</a></td>

                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="9" class="text-center">No messages found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Resolved Staff Complaints -->
<div class="mb-5">
    <h5 class="mb-3 text-success">Resolved Staff Complaints</h5>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Staff Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Received</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resolvedStaff = $connect->query("SELECT * FROM staff_complaints WHERE recipient = 'admin' AND status = 'resolved' ORDER BY submitted_at DESC");
                if ($resolvedStaff && $resolvedStaff->num_rows > 0):
                    $count = 1;
                    while ($row = $resolvedStaff->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= htmlspecialchars($row['staff_name']) ?></td>
                    <td><?= htmlspecialchars($row['staff_email']) ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                    <td><span class="badge bg-success"><?= ucfirst($row['status']) ?></span></td>
                    <td><?= date('d M Y', strtotime($row['submitted_at'])) ?></td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="7" class="text-center">No resolved staff complaints.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Resolved Teacher Complaints -->
<div class="mb-5">
    <h5 class="mb-3 text-success">Resolved Teacher Complaints</h5>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Teacher Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Received</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resolvedTeacher = $connect->query("SELECT * FROM teacher_complaints WHERE recipient = 'admin' AND status = 'resolved' ORDER BY submitted_at DESC");
                if ($resolvedTeacher && $resolvedTeacher->num_rows > 0):
                    $count = 1;
                    while ($row = $resolvedTeacher->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= htmlspecialchars($row['teacher_name']) ?></td>
                    <td><?= htmlspecialchars($row['teacher_email']) ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                    <td><span class="badge bg-success"><?= ucfirst($row['status']) ?></span></td>
                    <td><?= date('d M Y', strtotime($row['submitted_at'])) ?></td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="7" class="text-center">No resolved teacher complaints.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('footer.php'); ?>
