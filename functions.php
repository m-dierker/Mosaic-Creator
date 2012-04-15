<?php

require('facebook-php-sdk/src/facebook.php');
require('config.php');

function getFacebookObject()
{
	$facebook = new Facebook(array(
	'appId' => FACEBOOK_APP_ID,
	'secret' => FACEBOOK_APP_SECRET));

	return $facebook;
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


?>