<?php
include('header.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'teacher') {
    header("Location: ../../teacher_login.php"); // Change to your actual login page path
    exit();
}

$user_email = $_SESSION['user_email'];
?>



        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Teacher-Dashboard</h3>
                <h6 class="op-7 mb-2"> Teacher action panel</h6>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <!-- <a href="#" class="btn btn-label-info btn-round me-2">Manage</a> -->
              </div>
            </div>
            <div class="row">
            <div class="col-sm-6 col-md-3">
                <a href="video.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-primary card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center">
                            <i class="icon-social-youtube"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                            <h4 class="card-title">Videos</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>

                <div class="col-sm-6 col-md-3">
                <a href="notes.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-secondary card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center ">
                            <i class="icon-book-open"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                            <h4 class="card-title">Notes</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>

                <div class="col-sm-6 col-md-3">
                <a href="assignment.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-success card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center ">
                            <i class="icon-folder-alt"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                            <h4 class="card-title">Assignment</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>
                <div class="col-sm-6 col-md-3">
                <a href="question.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-danger card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center ">
                            <i class="icon-note"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats ">
                            <div class="numbers">
                            <h4 class="card-title">Question Paper</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>
                <div class="col-sm-6 col-md-3">
                <a href="help_teacher_desk.php" style="text-decoration: none; color: inherit;">
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
                
                <div class="col-sm-6 col-md-3">
                <a href="teacher_profile.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-danger card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center ">
                            <i class="icon-people"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats ">
                            <div class="numbers">
                            <h4 class="card-title">Profile</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>
                <div class="col-sm-6 col-md-3">
                <a href="teacher_complint.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-info card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center ">
                            <i class="icon-note"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats ">
                            <div class="numbers">
                            <h4 class="card-title">Complaint</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>
                <div class="col-sm-6 col-md-3">
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