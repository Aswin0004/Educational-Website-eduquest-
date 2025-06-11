<?php
$connect = new mysqli("localhost", "root", "", "eduquest");
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$type = $_GET['type'] ?? '';
$id = $_GET['id'] ?? '';

if (!$id || !$type) {
    die("Invalid request.");
}

$table = '';
switch ($type) {
    case 'staff':
        $table = 'staff_complaints';
        break;
    case 'teacher':
        $table = 'teacher_complaints';
        break;
    default:
        die("Invalid type.");
}

$update = $connect->query("UPDATE $table SET status = 'resolved' WHERE id = '$id'");

if ($update) {
    echo "<script>alert('Marked as resolved.'); window.location.href='help_admin_desk.php';</script>";
} else {
    echo "<script>alert('Error updating status.'); window.location.href='help_admin_desk.php';</script>";
}
?>
