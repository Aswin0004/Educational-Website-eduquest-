<?php
session_start();
require_once "login/db.php";

if (!isset($_SESSION['user_email'])) {
    header("Location: login/login.php");
    exit();
}

include("header.php");

// Get course ID
$course_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch course details
$stmt = $conn->prepare("SELECT * FROM courses WHERE course_id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='container'><p>Course not found.</p></div>";
    include("footer.php");
    exit();
}

$course = $result->fetch_assoc();
$final_price = (!empty($course['discounted_price']) && $course['discounted_price'] < $course['price']) 
    ? $course['discounted_price'] 
    : $course['price'];
?>



<head>
    <meta charset="UTF-8">
    <title>Checkout - <?= htmlspecialchars($course['course_name']) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .checkout-container {
            max-width: 900px;
            margin: 40px auto;
            background: #f9f9f9;
            padding: 30px;
            border-radius: 8px;
        }
        .checkout-summary {
            background: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

<div class="checkout-container">
    <h2 class="mb-4">Course Checkout</h2>

    <div class="checkout-summary mb-4">
        <h4><?= htmlspecialchars($course['course_name']) ?></h4>
        <p>
            <strong>Price:</strong>
            <?php if ($course['discounted_price'] > 0): ?>
                <del>₹<?= number_format($course['price'], 2) ?></del>
                <strong class="text-success"> ₹<?= number_format($course['discounted_price'], 2) ?></strong>
            <?php else: ?>
                ₹<?= number_format($course['price'], 2) ?>
            <?php endif; ?>
        </p>
        <p><?= nl2br(htmlspecialchars($course['short_notes'])) ?></p>
    </div>

    <form action="payment_gateway.php" method="post">
        <input type="hidden" name="course_id" value="<?= $course['course_id'] ?>">
        <input type="hidden" name="amount" value="<?= $final_price ?>">

        <h4>Your Details</h4>
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required value="<?= $_SESSION['user_name'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required value="<?= $_SESSION['user_email'] ?>">
        </div>
        <div class="form-group">
            <label>Phone:</label>
            <input type="tel" name="phone" class="form-control" required>
        </div>
        <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" class="form-control" required></textarea>
                    </div>
        <p>If place your order oru Team will contact you</p>

        <button type="submit" class="btn btn-primary mt-3">Place Order</button>
    </form>
</div>






<?php

include('footer.php');

?>