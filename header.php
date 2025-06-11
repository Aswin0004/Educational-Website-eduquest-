
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>EduQuest</title>

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="//fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="//fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
  </head>
  <body id="home">
<section class=" w3l-header-4">
	<!--header-->
	<header id="site-header">
		<div class="container">
			<nav class="navbar navbar-expand-lg navbar-dark stroke">
				<h1><a class="navbar-brand" href="index.html">
					<span class="fa fa-book"></span> EduQuest
				</a></h1>
				<!-- if logo is image enable this   
			<a class="navbar-brand" href="#index.html">
				<img src="image-path" alt="Your logo" title="Your logo" style="height:35px;" />
			</a> -->
				<button class="navbar-toggler  collapsed bg-gradient" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon fa icon-expand fa-bars"></span>
					<span class="navbar-toggler-icon fa icon-close fa-times"></span>
					
				</button>
	  
				<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
					<ul class="navbar-nav ml-auto">
					<?php if(isset($_SESSION['user_email'])):
						include 'db.php'; ?> ?>

							<li class="nav-item active">
								<a class="nav-link" href="homepage.php">Home <span class="sr-only">(current)</span></a>
							</li>
							<li class="nav-item @@about__active">
								<a class="nav-link" href="event2.php">Event</a>
							</li>
							<li class="nav-item @@services__active">
								<a class="nav-link" href="blog2.php">Blog</a>
							</li>
							<li class="nav-item @@services__active">
								<a class="nav-link" href="Course.php">Course</a>
							</li>
							<li class="nav-item @@services__active">
								<a class="nav-link" href="contact2.php">Contact</a>
							</li>
							<li class="nav-item @@services__active">
								<a class="nav-link" href="profile.php">Profile</a>
							</li>
							<li class="nav-item @@services__active">
								<a class="nav-link" href="logout.php">Logout</a>
							</li>
						<?php else: ?>
							<li class="nav-item active">
								<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
							</li>
							<li class="nav-item @@about__active">
								<a class="nav-link" href="event.php">Event</a>
							</li>
							<li class="nav-item @@services__active">
								<a class="nav-link" href="blog.php">Blog</a>
							</li>
							<li class="nav-item @@services__active">
								<a class="nav-link" href="contact.php">Contact</a>
							</li>
							<li class="nav-item mr-2">
								<a href="login/login.php" class="btn btn-primary register d-lg-block btn-style">Login</a>
							</li>
							<?php endif; ?>
					</ul>
				</div>
				        <!-- toggle switch for light and dark theme -->
						<div class="mobile-position">
							<label class="theme-selector">
							  <input type="checkbox" id="themeToggle">
							  <i class="gg-sun"></i>
							  <i class="gg-moon"></i>
							</label>
						  </div>
						  <!-- //toggle switch for light and dark theme -->
			</nav>
		</div>
	  </header>
	<!--/header-->
</section>
<script src="assets/js/jquery-3.3.1.min.js"></script> <!-- Common jquery plugin -->
<!--bootstrap working-->
<script src="assets/js/bootstrap.min.js"></script>
<!--bootstrap working//-->
<!--/MENU-JS-->
<script>
	$(window).on("scroll", function () {
	  var scroll = $(window).scrollTop();
  
	  if (scroll >= 80) {
		$("#site-header").addClass("nav-fixed");
	  } else {
		$("#site-header").removeClass("nav-fixed");
	  }
	});
  
	//Main navigation Active Class Add Remove
	$(".navbar-toggler").on("click", function () {
	  $("header").toggleClass("active");
	});
	$(document).on("ready", function () {
	  if ($(window).width() > 991) {
		$("header").removeClass("active");
	  }
	  $(window).on("resize", function () {
		if ($(window).width() > 991) {
		  $("header").removeClass("active");
		}
	  });
	});
  </script>
  <!--//MENU-JS-->
<!-- disable body scroll which navbar is in active -->
<script>
$(function () {
  $('.navbar-toggler').click(function () {
    $('body').toggleClass('noscroll');
  })
});
</script>
<!-- disable body scroll which navbar is in active -->
<!--theme switcher dark and light mode script-->
<script>
	const bodyElement = document.querySelector('body');
	const themeToggle = document.querySelector('#themeToggle');
	const darkModeMql = window.matchMedia('(prefers-color-scheme: dark)');
  
	const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : userPreference(darkModeMql);
  
	if (currentTheme) {
	  bodyElement.classList.add(currentTheme);
  
	  if (currentTheme === 'dark') {
		themeToggle.checked = true;
	  }
	}
  
	function userPreference(e) {
	  if (e.matches) {
		bodyElement.classList.add("dark");
		return "dark"
	  } else {
		bodyElement.classList.remove("dark");
		return ""
	  }
	}
  
	darkModeMql.addListener(userPreference);
  
	function themeSwitcher(e) {
	  if (e.target.checked) {
		bodyElement.classList.add('dark');
		localStorage.setItem('theme', 'dark');
	  } else {
		bodyElement.classList.remove('dark');
		localStorage.setItem('theme', '');
	  }
	}
  
	themeToggle.addEventListener('change', themeSwitcher);
  </script>
  <!--theme switcher dark and light mode script//-->
