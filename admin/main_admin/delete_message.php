<?php
$connect = new mysqli("localhost", "root", "", "eduquest");

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $sql = "DELETE FROM contact_messages WHERE id = $id";
    if ($connect->query($sql)) {
        header("Location: Help_admin_desk.php?deleted=1"); // Redirect back to the message list page
        exit;
    } else {
        echo "Error deleting message: " . $connect->error;
    }
} else {
    echo "Invalid message ID.";
}
$connect->close();
