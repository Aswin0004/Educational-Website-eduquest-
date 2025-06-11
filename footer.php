
<section class="w3l-footer-29-main">
	<div class="footer-29 py-5 ">
	  <div class="container">
		<div class="grid-col-4 footer-top-29">
			<div class="footer-list-29 footer-1">
				<h2 class="footer-title-29">About Us</h2>
<p class="para">Ipsum dolor sit amet, consectetur adipisicing elit. Itaque quis repellendus nesciunt quam cupiditate explicabo modi non error consequatur sunt molestiae laboriosam adipisci voluptatem possimus</p>
				
			</div>
			<div class="footer-list-29 footer-2">
				<ul>
					<h6 class="footer-title-29">Latest News</h6>
					<li><a href="#pages">Programming language</a>
					<h5><a href="#pages">by Admin</a></h5></li>
					<li><a href="#pages">Graduate Admissions</a><h5><a href="#pages">by Admin</a></h5></li>
					<li><a href="#pages">Committed to educating</a><h5><a href="#pages">by Admin</a></h5></li>
				</ul>
			</div>
			<div class="footer-list-29 footer-3">
				<div class="properties">
					<h6 class="footer-title-29">Contact Us</h6>

				<ul>
					<li><p><span class="fa fa-map-marker"></span>California, #32841 block,
						#221DRS 75 West Rock,
						Maple Building, UK.</p></li>
					<li><a href="tel:+7-800-999-800"><span class="fa fa-phone"></span> +(21)-255-999-8888</a></li>
					<li><a href="mailto:estate-mail@support.com" class="mail"><span class="fa fa-envelope-open-o"></span> example@mail.com</a></li>
				</ul>
			</div>
			</div>
			<div class="footer-list-29 footer-4">
				<ul>
					<h6 class="footer-title-29">Useful Links</h6>
					<?php if(isset($_SESSION['user_email'])):
						include 'db.php'; ?> ?>

							<li >
								<a  href="homepage.php">Home </a>
							</li>
							<li >
								<a  href="event2.php">Event</a>
							</li>
							<li >
								<a href="blog2.php">Blog</a>
							</li>
							<li >
								<a href="course.php">Course</a>
							</li>
							<li >
								<a  href="contact2.php">Contact</a>
							</li>
							<li >
								<a  href="profile.php">Profile</a>
							</li>
							<li >
								<a  href="logout.php">Logout</a>
							</li>
						<?php else: ?>
							<li >
								<a  href="index.php">Home </a>
							</li>
							<li >
								<a  href="event.php">Event</a>
							</li>
							<li >
								<a  href="blog.php">Blog</a>
							</li>
							<li>>
								<a  href="contact.php">Contact</a>
							</li>
							<li >
								<a href="login/login.php">Login</a>
							</li>
							<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class=" bottom-copies row">
			<p class="copy-footer-29 col-lg-8">© 2020 Tutee. All rights reserved | Designed by <a href="//w3layouts.com">W3layouts</a></p>
			<ul class="list-btm-29 col-lg-4">
				<li><a href="#link">Privacy policy</a></li>
				<li><a href="#link">Terms of service</a></li>
			  </ul>
		</div>
		</div>
	</div>
  </section>

<!-- move top -->
<button onclick="topFunction()" id="movetop" title="Go to top">
	<span class="fa fa-level-up"></span>
</button>
<script>
	// When the user scrolls down 20px from the top of the document, show the button
	window.onscroll = function () {
		scrollFunction()
	};

	function scrollFunction() {
		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			document.getElementById("movetop").style.display = "block";
		} else {
			document.getElementById("movetop").style.display = "none";
		}
	}

	// When the user clicks on the button, scroll to the top of the document
	function topFunction() {
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	}
</script>
<!-- /move top -->

</body>

</html>
