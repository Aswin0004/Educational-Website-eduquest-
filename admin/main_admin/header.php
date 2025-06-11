<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  echo "<script>alert('Please log in first.'); window.location.href='../../login/admin_login.php';</script>";
  exit();
}

// Get the logged-in user's email from the session
$admin_email = $_SESSION['admin_email'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> Admin Dashboard</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="assets/img/favicon.ico"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
          <a class="navbar-brand" href="index.php" style="display: flex; align-items: center; text-decoration: none;">
                                <img src="assets/img/favicon.ico" alt="EduQuest Logo" style="height: 40px; margin-right: 12px;">
                                <span style="font-weight: bold; font-size: 24px; color: aliceblue;">EduQuest</span>
                            </a>
                            
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item">
                <a href="admin.php">
                  <i class="fas fa-home"></i>
                  <p>Admin-Dashboard</p>
                  <span class="badge badge-success"></span>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Components</h4>
              </li>

              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                <i class="icon-people"></i>
                  <p>Staff</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="staff.php">
                        <span class="sub-item">All Staff</span>
                      </a>
                    </li>
                    <li>
                      <a href="add_staff.php">
                        <span class="sub-item">Appoint New staff</span>
                      </a>
                    </li>
                    
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                <i class="icon-user-follow"></i>
                  <p>Teacher</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="teacher.php">
                        <span class="sub-item">All Teachers</span>
                      </a>
                    </li>
                    <li>
                      <a href="add_teacher.php">
                        <span class="sub-item">Appoint New Teachers</span>
                      </a>
                    </li>
                    
                  </ul>
                </div>
              </li>

              

              
              <li class="nav-item">
                <a href="student.php">
                <i class="icon-eyeglass"></i>
                  <p>Student</p>
                  <span class="badge badge-success"></span>
                </a>
              </li>

             <li class="nav-item">
                <a href="Help_admin_desk.php">
                  <i class="icon-shield"></i> 
                  <p>Help-Desk</p>
                  <span class="badge badge-success"></span>
                </a>
              </li>
              
              
              <!-- <li class="nav-item">
                <a href="course.php">
                  <i class="icon-notebook"></i>
                  <p>Cousre</p>
                  <span class="badge badge-success"></span>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="sent_mail.php">
                <i class="icon-envelope"></i>
                  <p>Mails</p>
                  <span class="badge badge-success"></span>
                </a>
              </li> 

              <li class="nav-item">
                  <a  href="logout.php">
                  <i class="icon-logout"></i>
                      <p>Logout</p>
                  </a>
              </li>



              
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.html" class="logo">
                <img
                  src="assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              
            </div>
          </nav>
          <!-- End Navbar -->
        </div>