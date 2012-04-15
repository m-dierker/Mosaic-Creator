<?php

require('facebook-php-sdk/src/facebook.php');
require('config.php');

function getFacebookObject()
{
	d('Getting the facebook object');

	$facebook = new Facebook(array(
	'appId' => FACEBOOK_APP_ID,
	'secret' => FACEBOOK_APP_SECRET));

	return $facebook;
}

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

?>