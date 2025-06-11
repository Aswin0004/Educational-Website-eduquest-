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
$result = $conn->query("SELECT * FROM purchases WHERE status = 'pending'");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $purchase_id = (int)$_POST['purchase_id'];

    // Update status to approved
    $stmt = $conn->prepare("UPDATE purchases SET status = 'approved' WHERE id = ?");
    $stmt->bind_param("i", $purchase_id);
    $stmt->execute();
    echo '<div style="margin-top: 100px; text-align: center; padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; max-width: 500px; margin-left: auto; margin-right: auto;">
     successful.
  </div>';
echo '<script>
    setTimeout(function() {
        window.location.href = "admin.php";
    }, 2000); 
  </script>';
}
?>



<div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Admin-Dashboard</h3>
                    <h6 class="op-7 mb-2"> Admin action panel</h6>
                </div>
            </div>



            <h2>Pending Course Requests</h2>
<table class="table table-bordered">
    <tr>
        <th>Name</th><th>Email</th><th>Course ID</th><th>Amount</th><th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['user_name']) ?></td>
        <td><?= htmlspecialchars($row['user_email']) ?></td>
        <td><?= $row['course_id'] ?></td>
        <td>₹<?= $row['amount'] ?></td>
        <td>
            <form action="student.php" method="post">
                <input type="hidden" name="purchase_id" value="<?= $row['id'] ?>">
                <button class="btn btn-success btn-sm" type="submit">Approve</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

        </div>
</div>





<?php
include('footer.php');
?>
