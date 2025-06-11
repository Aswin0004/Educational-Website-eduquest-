<?php
include('header.php');
?>
<?php
$connect = new mysqli("localhost", "root", "", "eduquest");
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
?>
<div class="container">
    <div class="page-inner">
    <div class="container mt-5">
    <h3 class="fw-bold mb-4">Help Desk</h3>

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
                $staffResult = $connect->query("SELECT * FROM staff_complaints WHERE recipient = 'teacher' AND status = 'pending' ORDER BY submitted_at DESC");

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
<td><a href="resolve_message.php?type=staff&id=<?= $row['id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Mark as completed?');">Complete</a></td>


                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="9" class="text-center">No staff complaints found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mb-5">
    <h5 class="mb-3">Messages from Admin</h5>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Received</th>
                    <th>Actions</th>
                    <th>Resolve</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch pending admin messages for teachers (or change 'teacher' to 'staff' for staff)
                $staffResult = $connect->query("SELECT * FROM admin_messages WHERE recipient_type = 'teacher' AND status = 'pending' ORDER BY sent_at DESC");

                if ($staffResult && $staffResult->num_rows > 0):
                    $count = 1;
                    while ($row = $staffResult->fetch_assoc()):
                ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= htmlspecialchars($row['subject']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                        <td>
                            <span class="badge bg-<?= $row['status'] == 'approved' ? 'success' : 'warning' ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                        </td>
                        <td><?= date('d M Y', strtotime($row['sent_at'])) ?></td>
                        <td>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'pending'): ?>
                                <a href="resolve_message.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Mark as resolved?');">Resolve</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="9" class="text-center">No pending messages found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>



</div>
</div></div>
<?php
include('footer.php');
?>