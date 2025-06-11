<?php
include ('header.php');
?>



        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Staff-Dashboard</h3>
                <h6 class="op-7 mb-2"> Staff action panel</h6>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <!-- <a href="#" class="btn btn-label-info btn-round me-2">Manage</a> -->
                <a href="add_course.php" class="btn btn-primary btn-round">Add Course</a>
              </div>
            </div>
            <div class="row">
            <div class="col-sm-6 col-md-3">
                <a href="course.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-primary card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center">
                            <i class="icon-book-open"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                            <h4 class="card-title">Course</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>

                <div class="col-sm-6 col-md-3">
                <a href="event.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-secondary card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center ">
                            <i class="icon-calendar"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                            <h4 class="card-title">Event</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>

                <div class="col-sm-6 col-md-3">
                <a href="blog.php" style="text-decoration: none; color: inherit;">
                    <div class="card card-stats card-success card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-5">
                            <div class="icon-big text-center ">
                            <i class="icon-directions"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                            <h4 class="card-title">Blog</h4>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </a>
                </div>

                <div class="col-sm-6 col-md-3">
                <a href="Help_staf_desk.php" style="text-decoration: none; color: inherit;">
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
                
                <div class="col-md-4">
                <a href="staff_profile.php" style="text-decoration: none; color: inherit;">
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
                <div class="col-md-4">
                <a href="staff_complint.php" style="text-decoration: none; color: inherit;">
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