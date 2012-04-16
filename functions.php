<?php

require('facebook-php-sdk/src/facebook.php');
require('config.php');

// Get the Facebook object
function getFacebookObject()
{ 
	$facebook = new Facebook(array(
	'appId' => FACEBOOK_APP_ID,
	'secret' => FACEBOOK_APP_SECRET));

	return $facebook;
}

// Get the active facebook user using the PHP API
function getFacebookUser()
{
	$facebook = getFacebookObject();

	return $facebook->getUser();
}

// Redirect if the user isn't logged in
function redirectIfNotLoggedIn($facebook)
{
	$user = $facebook->getUser();

	if($user == 0)
		login($facebook);
}

// Redirects to the Facebook login
function login($facebook)
{
	header('Location: ' . $facebook->getLoginUrl(array('scope' => FACEBOOK_SCOPE)));
}

// Debug logging
function d($message)
{
	error_log($message . "\n", 3, LOG_FILE);
}

// Writes the HTML for a step
function makeStep($title, $desc, $id)
{
	?>

	<div class="step" id="<?php echo $id ?>">
		<div class="stepTitle">
			<h3><?php echo $title ?></h3>
		</div>
		<div class="stepDesc">
			<p><?php echo $desc ?></p>
		</div>
	</div>

	<hr>

	<?
}

?>