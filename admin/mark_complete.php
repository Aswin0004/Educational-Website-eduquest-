<?php
$connect = new mysqli("localhost", "root", "", "eduquest");
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];

    // Set table name based on type
    $table = $type === 'staff' ? 'staff_complaints' : ($type === 'teacher' ? 'teacher_complaints' : null);

    if ($table) {
        $stmt = $connect->prepare("UPDATE `$table` SET status = 'resolved' WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: help_staf_desk.php?msg=approved");
            exit;
        } else {
            echo "Error updating status.";
        }

        $stmt->close();
    } else {
        echo "Invalid type.";
    }
} else {
    echo "Invalid request.";
}

$connect->close();
?>
