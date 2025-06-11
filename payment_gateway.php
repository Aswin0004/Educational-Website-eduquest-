<?php
session_start();
require_once "login/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name      = $_POST['name'];
    $email     = $_POST['email'];
    $phone     = $_POST['phone'];
    $address   = $_POST['address'];
    $course_id = (int)$_POST['course_id'];
    $amount    = (float)$_POST['amount'];

    $stmt = $conn->prepare("INSERT INTO purchases (user_email, user_name, course_id, address, phone, amount) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissd", $email, $name, $course_id, $address, $phone, $amount);
    if ($stmt->execute()) {
        include("header.php");
        ?>
        <section class="section text-center">
            <div class="container">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <h3 class="text-success">Your action registered</h3>
                <p>Our team will contact you soon!</p>
                <a href="homepage.php" class="btn btn-primary mt-3">Back to Home</a>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>
        </section>
        <?php
        include("footer.php");
    } else {
        echo "Error: Could not register your request.";
    }

    $stmt->close();
    $conn->close();
}
?>
