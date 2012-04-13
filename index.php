<?php

require('facebook-php-sdk/src/facebook.php');
require('config.php');


$facebook = new Facebook(array(
	'appId' => FACEBOOK_APP_ID,
	'secret' => FACEBOOK_APP_SECRET));

$user = $facebook->getUser();


redirectIfNotLoggedIn($user, $facebook);

echo('logged in');

// Redirect if the user isn't logged in
function redirectIfNotLoggedIn($user, $facebook)
{
	if(!$user)
	{
		header('Location: ' . $facebook->getLoginUrl(array(FACEBOOK_SCOPE)));
	}
}

?>