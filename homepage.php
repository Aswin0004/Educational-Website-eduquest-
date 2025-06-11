<?php
session_start();
require_once "login/db.php"; // Include database connection

// Redirect to login page if user not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login/login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

include ("header.php");
?>

<section class="w3l-hero-headers-9" id="home">
  <div class="slide header11" data-selector="header11">
      <div class="container">
          <div class="banner-text ">
              <h5 class=" ">Present Education<br> in beautiful way!</h5>
              <p class=" ">Adipi sicing elit. Quia, aliquid voluptatum corporis Dicta. Deleniti possimus culpa nemo asperiores aperiam mollitia, maiores Lorem ipsum dolor.</p>
              <div >
              <a href="course.php" class="btn btn-style btn-primary">Buy courses</a>
            </div>
          </div>
      </div>
  </div>
</section>

<section class="w3l-call-to-action_9">
    <div class="call-w3">
        <div class="container">
            <div class="booking-form-content">
                <div class="main-titles-head ">
                <h3 class="header-name">You Can learn anything
                </h3>
                <p class="tiltle-para editContent ">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic fuga sit illo modi aut aspernatur tempore laboriosam saepe dolores eveniet.</p>
            </div>
               <div class="row text-center">
                <div class="col-lg-4 col-md-6 propClone about-line-top ">
                    <div class="area-box color-white editContent box-active">
                        <div class="icon-back"><span class="fa fa-thumbs-up"></span></div>
                        
                    <h5><a href="blog.html" class="editContent">
                        Unlimited Access</a></h5>
                    <p class="para editContent">Sit amet consect etur adipi sicing elit. Rem quib usdam corporis, dolores
                        quos, nobis culpa est</p>
            </div>
            </div>
            <div class="col-lg-4 col-md-6 propClone about-line-top ">
                <div class="area-box color-white editContent">
                    <div class="icon-back"><span class="fa fa-users"></span></div>
                    
                <h5><a href="blog.html" class="editContent">
                    Expert Teachers</a></h5>
                <p class="para editContent">Sit amet consect etur adipi sicing elit. Rem quib usdam corporis, dolores
                    quos, nobis culpa est</p>
        </div>
        </div>
        <div class="col-lg-4 col-md-6 propClone about-line-top">
            <div class="area-box color-white editContent box-active">
                <div class="icon-back"><span class="fa fa-pencil"></span></div>
                
            <h5><a href="blog.html" class="editContent">
                Learn Anything</a></h5>
            <p class="para editContent">Sit amet consect etur adipi sicing elit. Rem quib usdam corporis, dolores
                quos, nobis culpa est</p>
    </div>
    </div>
    <div class="col-lg-4 col-md-6 propClone about-line-top ">
        <div class="area-box color-white editContent">
            <div class="icon-back"><span class="fa fa-book"></span></div>
            
        <h5><a href="blog.html" class="editContent">
            Many Courses</a></h5>
        <p class="para editContent">Sit amet consect etur adipi sicing elit. Rem quib usdam corporis, dolores
            quos, nobis culpa est</p>
</div>
</div>
<div class="col-lg-4 col-md-6 propClone about-line-top ">
    <div class="area-box color-white editContent box-active">
        <div class="icon-back"><span class="fa fa-star"></span></div>
        
    <h5><a href="blog.html" class="editContent">
        Bright Future</a></h5>
    <p class="para editContent">Sit amet consect etur adipi sicing elit. Rem quib usdam corporis, dolores
        quos, nobis culpa est</p>
</div>
</div>
<div class="col-lg-4 col-md-6 propClone about-line-top ">
    <div class="area-box color-white editContent">
        <div class="icon-back"><span class="fa fa-check"></span></div>
        
    <h5><a href="blog.html" class="editContent">
        Verified Course</a></h5>
    <p class="para editContent">Sit amet consect etur adipi sicing elit. Rem quib usdam corporis, dolores
        quos, nobis culpa est</p>
</div>
</div>
               </div>
            </div>
        </div>
    </div>
</section>
<section class="w3l-specification-6">
    <div class="specification-layout editContent">
        <div class="container">
				<div class="grid">
					<figure class="effect-apollo ser-bg1">
						<figcaption>
							<h5><a href="#url">Successfully Trained</a></h5>
							<p class="para">Lorem ipsum dolor sit amet.Sit amet consect etur adipi sicing elit.</p>
						</figcaption>			
					</figure>
					<figure class="effect-apollo ser-bg2">
						<figcaption>
							<h5><a href="#url">We Proudly Received</a></h5>
							<p class="para">Lorem ipsum dolor sit amet.Sit amet consect etur adipi sicing elit.</p>
						</figcaption>			
					</figure>
					<figure class="effect-apollo ser-bg3">
						<figcaption>
							<h5><a href="#url">We Are Getting Featured On</a></h5>
							<p class="para">Lorem ipsum dolor sit amet.Sit amet consect etur adipi sicing elit.</p>
						</figcaption>			
					</figure>
					<figure class="effect-apollo ser-bg4">
						<figcaption>
							<h5><a href="#url">Firmly Established</a></h5>
							<p class="para">Lorem ipsum dolor sit amet.Sit amet consect etur adipi sicing elit.</p>
						</figcaption>			
					</figure>
				</div>
                  </div>
        </div>
</section>



<section class="w3l-clients" id="client">
    <div class="call-w3">
        <div class="container">
            <!-- main-slider -->
            <div class="main-slider text-center">
                <div class="csslider infinity" id="slider1">
                    <input type="radio" name="slide" checked="checked" id="slides_1">
                    <input type="radio" name="slide" id="slides_2">
                    <input type="radio" name="slide" id="slides_3">
                    <ul>
                        <li>
                            <div class="slider-info">
                                <div class="d-grid hh14-text">
                                    <img class="img-responsive" src="assets/images/c3.jpg" alt="image">
                                    <div class="hh14-info">
                                        <h6>Limitless learning</h6>
                                        <p class="para">Consectetur adipisicing Lorem ipsum dolor sit amet,elit, sed do
                                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                            minim incididunt ut labore et dolore magna aliqua. Ut enim ad
                                            minim.</p>
                                      <h4>Jack Willson</h4>
                                    </div>

                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="slider-info">
                                <div class="d-grid hh14-text">
                                    <img class="img-responsive" src="assets/images/c1.jpg" alt="image">
                                    <div class="hh14-info">
                                        <h6>World's best courses</h6>
                                        <p class="para">Consectetur adipisicing Lorem ipsum dolor sit amet,elit, sed do
                                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                            minim incididunt ut labore et dolore magna aliqua. Ut enim ad
                                            minim.</p>
                                            <h4>Nike samson</h4>
                                    </div>

                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="slider-info">
                                <div class="d-grid hh14-text">
                                    <img class="img-responsive" src="assets/images/c2.jpg" alt="image">
                                    <div class="hh14-info">
                                        <h6>Popular Courses</h6>
                                        <p class="para">Consectetur adipisicing Lorem ipsum dolor sit amet,elit, sed do
                                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                            minim incididunt ut labore et dolore magna aliqua. Ut enim ad
                                            minim.</p>
                                            <h4>Milky Deo</h4>
                                    </div>

                                </div>
                            </div>
                        </li>
                    </ul>
                    <!-- <div class="arrows">
                        <label for="slides_1"></label>
                        <label for="slides_2"></label>
                        <label for="slides_3"></label>
                        <label for="slides_4"></label>
                    </div> -->
                    <div class="navigation">
                        <div>
                            <label for="slides_1"></label>
                            <label for="slides_2"></label>
                            <label for="slides_3"></label>
                        </div>
                </div>
            </div>
            <!-- /main-slider -->
        </div>
    </div>
        </div>
</section>


<?php
include('footer.php')
?>