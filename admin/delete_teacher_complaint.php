<?php
$connect = new mysqli("localhost", "root", "", "eduquest");
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $connect->prepare("DELETE FROM teacher_complaints WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: help_staf_desk.php?msg=deleted");
        exit;
    } else {
        echo "Error deleting message.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$connect->close();
?>
