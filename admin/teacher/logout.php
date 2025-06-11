<?php
// Start the session
session_start();

// Destroy the session variables
session_unset();  // This will clear all session variables

// Destroy the session itself
session_destroy();  // This will destroy the entire session

// Prevent the browser from caching the page
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies

// Redirect to login page
header("Location: ../../login/teacher_login.php");
exit();
?>
