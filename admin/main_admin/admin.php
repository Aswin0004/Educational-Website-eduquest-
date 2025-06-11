
<?php
include('header.php');
// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo "<script>alert('Please log in first.'); window.location.href='admin_login.php';</script>";
    exit();
}

// Get the logged-in user's email from the session
$admin_email = $_SESSION['admin_email'];
?>




        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Admin-Dashboard</h3>
                <h6 class="op-7 mb-2"> Admin action panel</h6>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                <a href="#" class="btn btn-primary btn-round">Add Customer</a>
              </div>
            </div>
            <div class="row">
            <div class="col-md-4">
                <a href="staff.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-primary card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center">
                            <i class="icon-people"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                            <h4 class="card-title">Staff</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>

                <div class="col-md-4">
                <a href="teacher.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-secondary card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center ">
                            <i class="icon-user-follow"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                            <h4 class="card-title">Teacher</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>

                <div class="col-md-4">
                <a href="student.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-success card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center ">
                            <i class="icon-eyeglass"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                            <h4 class="card-title">Students</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>

                <div class="col-md-4">
                <a href="Help_admin_desk.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-warning card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center ">
                            <i class="icon-shield"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats ">
                            <div class="numbers">
                            <h4 class="card-title">Help-Desk</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div> 
                
                <!-- <div class="col-md-4">
                <a href="course.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-danger card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center ">
                            <i class="icon-notebook"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats ">
                            <div class="numbers">
                            <h4 class="card-title">Courses</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div> -->
             <div class="col-md-4">
                <a href="sent_mail.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-info card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center ">
                            <i class="icon-envelope"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats ">
                            <div class="numbers">
                            <h4 class="card-title">Mails</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>
                <div class="col-md-4">
                <a href="logout.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-black card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center ">
                            <i class="icon-logout"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats ">
                            <div class="numbers">
                            <h4 class="card-title">Logout</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>
            </div>
            
            
          </div>
            
        </div>


        
        <?php
include('footer.php');
?>