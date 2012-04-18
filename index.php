
<!DOCTYPE html>


<?php

// Require functions.php, which includes things you need for facebook, and includes JQuery.
require_once('functions.php');
require_once('fileUploads.php');

?>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>MP6 Mosaic Creator - Designed by Matthew Dierker</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Create beautiful mosaic images using your own pictures, free!">
	<meta name="author" content="Matthew Dierker">

	<!-- Le styles -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<![endif]-->

		</head>

		<body>

			<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<!-- This is for mobile... I think -->
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
						<a class="brand" href="#">MP6.3 Mosaic Creator</a>
						<div class="nav-collapse">
							<ul class="nav">
								<li class="active"><a href="#">Home</a></li>
								<li class="dropdown">
									<a class ="dropdown-toggle" data-toggle="dropdown" href="https://wiki.engr.illinois.edu/display/cs225/MP+6">Original MP Spec <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="https://wiki.engr.illinois.edu/display/cs225/MP+6.1">MP 6.1 (Part 1)</a></li>
										<li><a href="https://wiki.engr.illinois.edu/display/cs225/MP+6.2">MP 6.2 (Part 2)</a></li>
									</ul>
								</li>

								<!-- <li><a href="#contact">Contact</a></li> -->
							</ul>
						</div><!--/.nav-collapse -->
					</div>
				</div>
			</div>

			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span8">
						<div class="hero-unit">
							<h1>Create your own Mosaic!</h1>
							<p>Use your own images to make a mosaic, like these! <b>To get started, just login on the right.</b></p> 

							<div class="onLogoutSlide hide">
								<img src="img/mosaic-sample.png">&nbsp;&nbsp;&nbsp;<img src="img/mosaic-sample.png"><br><br>
								<a class="btn btn-primary btn-large" href="img/mosaic.png">See them bigger!</a>
							</div>
							<div class="onLogoutHide onLoginSlideIn hide">
								<a class="btn btn-primary btn-large" href="img/mosaic.png">See an example!</a>
							</div>

						</div>

						<!-- Start Step 1, File Uploading -->

						<div id="fileUpload" class="fileUpload step hide">
							<h2>Upload your Images</h2>


							<form id="fileupload" action="upload-plugin/server/" method="POST" enctype="multipart/form-data">
								<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
								<div class="row fileupload-buttonbar">
									<div class="span7">
										<!-- The fileinput-button span is used to style the file input field as button -->
										<span class="btn btn-success fileinput-button">
											<i class="icon-plus icon-white"></i>
											<span>Add files...</span>
											<input type="file" name="files[]" multiple>
										</span>
										<button type="submit" class="btn btn-primary start">
											<i class="icon-upload icon-white"></i>
											<span>Start upload</span>
										</button>
										<button type="reset" class="btn btn-warning cancel">
											<i class="icon-ban-circle icon-white"></i>
											<span>Cancel upload</span>
										</button>
										<button type="button" class="btn btn-danger delete">
											<i class="icon-trash icon-white"></i>
											<span>Delete</span>
										</button>
										<input type="checkbox" class="toggle">
									</div>
									<div class="span5">
										<!-- The global progress bar -->
										<div class="progress progress-success progress-striped active fade">
											<div class="bar" style="width:0%;"></div>
										</div>
									</div>
								</div>
								<!-- The loading indicator is shown during image processing -->
								<div class="fileupload-loading"></div>
								<br>
								<!-- The table listing the files available for upload/download -->
								<table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
							</form>
						

							<?php includeFileUploadImageGallery(); ?>

							<?php includeFileUploadTemplates(); ?>

						</div>

						<!-- End File Upload -->

						<!-- Start Select Source -->

						<div id="selectSource" class="selectSource step hide">

							<h2>Select the source image</h2>

							<div id="selectSourceGallery" class="selectSourceGallery">
							</div>

						</div>

						<!-- End Select Source -->

						<!-- Start Format Images -->

						<div id="formatImages" class="formatImages step hide">

							<h2>Format your images</h2>

						</div>

						<!-- End Format Images -->

					</div>
					<div class="span4">
						<div class="loginContainer roundedBox"> 
							<div class="onLoginHide onLogoutHide">
								Loading... <img src="img/pacman-loader.gif">
							</div>
							<div class="loginBox onLoginHide onLogoutFadeIn hide" id="loginBox">
								<h3>Login</h3>
								<p>We'll need you to login to facebook to start! If you don't have a facebook account, you're out of luck for now. Sorry! (but feel free to <a href="http://facebook.com">register</a>!)</p>

								<div class="fb-login-button">Login with Facebook</div>

							</div>
							<div class="logoutBox onLogoutHide onLoginFadeIn hide" id="logoutBox">
								<h3>
									Welcome <a class="fb-profile-link"><span class="fb-first-name"></span></a>!
								</h3>
								<p>
									<a class="btn btn-mini" href="javascript:logout();">Logout</a>
								</p>
							</div>
						</div>
						<div class="stepsContainer roundedBox onLoginFade hide" style="margin-top: 40px">
								<u><h2>Image Creation</h2></u>

								<?php 

								makeStep('1) Upload Images', 'Upload your images to the server', 'fileUploadStep');
								makeStep('2) Select Source', 'Pick one of your images to be the mosaic\'s background', 'selectSourceStep');
								makeStep('3) Format Images', 'Format your uploads so they can be included in a mosaic', 'formatImagesStep');

								?>

						</div>
					</div>
				</div>
			</div> <!-- /container -->

	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-dropdown.js"></script>
	<script src="js/jquery.color.js"></script>


	<!-- Start File Upload Scripts -->

	<?php includeFileUploadScripts(); ?>

	<!-- End File Upload Scripts -->


	<script type="text/javascript">
	var facebookName, facebookFirstName, facebookLastName, facebookID;
	var activeStep = null;
	</script>

	<script type="text/javascript" src="js/home.js"></script>

	<div id="fb-root"></div>
	<script>
	window.fbAsyncInit = function() {
		FB.init({
			appId      : <?php echo FACEBOOK_APP_ID; ?>,
			status     : true, 
			cookie     : true,
			xfbml      : true,
			oauth      : true,
		});

		facebookInitComplete();
	};
	(function(d){
		var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/en_US/all.js";
		d.getElementsByTagName('head')[0].appendChild(js);
	}(document));
	</script>


	

</body>
</html>