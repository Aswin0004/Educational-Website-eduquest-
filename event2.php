<?php
session_start();
include('header.php');
require_once "db.php";// Include database connection

// Redirect to login page if user not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login/login.php");
    exit();
}

$user_email = $_SESSION['user_email'];
// Fetch the latest event
$event_query = "SELECT * FROM events ORDER BY event_date DESC LIMIT 1";
$result = $conn->query($event_query);
$event = $result->fetch_assoc();
?>

<!-- breadcrumbs //-->
<section class="w3l-content-with-photo-4" id="about">
    <div class="content-with-photo4-block editContent">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 ">
                    <img src="ADMIN/<?php echo htmlspecialchars($event['main_event_image']); ?>" alt="product" class="img-responsive about-me">
                </div>
                <div class="my-bio col">
                <h3><?php echo htmlspecialchars($event['main_heading']); ?></h3>
                <p class="para mb-3"><?php echo date('d M, Y', strtotime($event['event_date'])); ?> - Organized by <?php echo htmlspecialchars($event['organized_by']); ?></p>
                <p class="para mb-3"><?php echo htmlspecialchars($event['description']); ?></p>
                </div>

            </div>

        </div>
    </div>
    </div>
</section>

<section class="w3l-recent-work">
	<div class="jst-two-col">
		<div class="container">
        <div class="booking-form-content">
                <div class="main-titles-head ">
                <h3 class="header-name">Highlights
                </h3>
                <p class="tiltle-para editContent "></p>
            </div>
<div class="row">
<?php if (!empty($event['sub_image1'])): ?>
<div class="col-lg-4 ">
	<img src="admin/<?php echo htmlspecialchars($event['sub_image1']); ?>" alt="product" class="img-responsive about-me">
</div>
            <?php endif; ?>
            <?php if (!empty($event['sub_image2'])): ?>
<div class="col-lg-4 ">
	<img src="admin/<?php echo htmlspecialchars($event['sub_image2']); ?>" alt="product" class="img-responsive about-me">
</div>
            <?php endif; ?>
            <?php if (!empty($event['sub_image3'])): ?>
<div class="col-lg-4 ">
	<img src="admin/<?php echo htmlspecialchars($event['sub_image3']); ?>" alt="product" class="img-responsive about-me">
</div>
<?php endif; ?>
</div>
		</div>
	</div>
</section>
<section class="w3l-team-main-6" id="team">
	<!-- /team-grids -->
	<div class="team-content-page editContent ">

		<div class="container">
        <div class="booking-form-content">
                <div class="main-titles-head ">
                <h3 class="header-name">Meet our Guests
                </h3><p class="tiltle-para editContent ">......................................................................</p>
            
                </div>
			<div class="row">
            <?php if (!empty($event['main_guest1'])): ?>
			  <div class="col team-team">
				<div class="our-team">
				  <div class="picture">
					<img src="admin/<?php echo htmlspecialchars($event['guest_images1']); ?>" alt="Guest 1" class="img-responsive about-me">
				  </div>
				  <div class="team-content">
					<h4 class="title"><?php echo htmlspecialchars($event['main_guest1']); ?></h4>
				  </div>
				  
				</div>
			  </div>
              <?php endif; ?>
              <?php if (!empty($event['main_guest2'])): ?>
				  <div class="col team-team">
				<div class="our-team">
				  <div class="picture">
					<img src="admin/<?php echo htmlspecialchars($event['guest_images2']); ?>" alt="Guest 2" class="img-responsive about-me">
				  </div>
				  <div class="team-content">
					<h4 class="title"><?php echo htmlspecialchars($event['main_guest2']); ?></h4>
				  </div>
				  
				</div>
			  </div>
              
            <?php endif; ?>
            <?php if (!empty($event['main_guest3'])): ?>
				  <div class="col team-team">
				<div class="our-team">
				  <div class="picture">
					<img src="admin/<?php echo htmlspecialchars($event['guest_images3']); ?>" alt="Guest 3" class="img-responsive about-me">
				  </div>
				  <div class="team-content">
					<h4 class="title"><?php echo htmlspecialchars($event['main_guest3']); ?></h4>
				  </div>
				  
				</div>
			  </div>
              <?php endif; ?>
			</div>
		  </div>
		  </div>
	</div>
	<!-- /team-grids -->
</section>

<?php
include('footer.php');
?>
