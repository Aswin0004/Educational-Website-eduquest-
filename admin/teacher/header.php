<?php
session_start();


require_once "../db.php"; // Ensure database connection
if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'teacher') {
  header("Location: ../../teacher_login.php");
  exit;
}
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
          <a class="navbar-brand" href="#" style="display: flex; align-items: center; text-decoration: none;">
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
                <a href="teacher.php">
                  <i class="fas fa-home"></i>
                  <p>Teacher-Dashboard</p>
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
                <a href="add_department.php">
                  <i class="icon-people"></i>
                  <p>Add Course Sections</p>
                  <span class="badge badge-success"></span>
                </a>
              </li>
 
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                <i class="icon-social-youtube"></i>
                  <p>videos</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="video.php">
                        <span class="sub-item">All Videos</span>
                      </a>
                    </li>
                    <li>
                      <a href="add_video.php">
                        <span class="sub-item">Add Videos</span>
                      </a>
                    </li>
                    
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                <i class="icon-book-open"></i>
                  <p>Notes</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="notes.php">
                        <span class="sub-item">All Notes</span>
                      </a>
                    </li>
                    <li>
                      <a href="add_notes.php">
                        <span class="sub-item">Add Notes</span>
                      </a>
                    </li>
                    
                  </ul>
                </div>
              </li>
              
              <li class="nav-item">
                <a href="assignment.php">
                <i class="icon-folder-alt"></i>
                  <p>Assignment</p>
                  <span class="badge badge-success"></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="question.php">
                <i class="icon-note"></i>
                  <p>Question paper</p>
                  <span class="badge badge-success"></span>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="help_teacher_desk.php">
                  <i class="icon-shield"></i> 
                  <p>Help-Desk</p>
                  <span class="badge badge-success"></span>
                </a>
              </li>
              
              
              <li class="nav-item">
                <a href="teacher_profile.php">
                  <i class="icon-people"></i>
                  <p>Profile</p>
                  <span class="badge badge-success"></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="teacher_complint.php">
                <i class="icon-note"></i>
                  <p>Complaint</p>
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