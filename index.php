<?php


require('functions.php');


$facebook = new Facebook(array(
	'appId' => FACEBOOK_APP_ID,
	'secret' => FACEBOOK_APP_SECRET));

redirectIfNotLoggedIn($facebook);

$user_id = $facebook->getUser();

loadPhotos($facebook);


exit();

$facebook = getFacebookObject();

// Redirect to a login page if the given user isn't logged in
redirectIfNotLoggedIn($facebook);

// The user is logged in! Let's get their photos
loadPhotos($facebook);


// Downloads the user's photos
function loadPhotos($facebook)
{
	$user_profile = $facebook->api('/me', 'GET');
	$user_id = $user_profile['id'];

	echo("Getting the photos for user ID: $user_id");

	$url = '/me/photos';

	while($url != "")
	{
		echo "Getting from URL: $url";
		$user_photos = $facebook->api($url, 'GET');

		foreach($user_photos['data'] as $imageID)
		{
			$img = $imageID['picture'];
			$img_id = $imageID['id'];

			writeImageToFile($img, "user-images/$user_id/", $img_id . '.jpg');
		}

		$url = "";

		if(array_key_exists('paging', $user_photos) && array_key_exists('next', $user_photos['paging']))
			$url = str_replace('https://graph.facebook.com', '', $user_photos['paging']['next']);
	}
}

function writeImageToFile($img, $path, $fileName)
{
	if(!file_exists($path . $fileName))
	{
		mkdir($path);
		$image = file_get_contents($img);
		file_put_contents($path . $fileName, $image);
	}
}





?>