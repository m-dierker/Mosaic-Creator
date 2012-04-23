<?php

require('functions.php');

$user = getFacebookUser();

if($user == 0)
{
	$user_ip = $_SERVER['REMOTE_ADDR'];
	d("Hacking attempt on the image processing script from user ip: $user_ip");
	die('hacking attempt');
}

$cmd = $_GET['cmd'];


switch($cmd)
{
	case 'square':
		$img_name = urldecode($_GET['name']);
		squareImage($img_name);
}

// Makes an image square
function squareImage($img_name)
{
	global $user;
	$img_path = escapeshellarg(getcwd() . "/upload-plugin/server/user-files/$user/files/$img_name");


	// See if the image is already a square
	$command = IMAGEMAGICK_IDENTIFY_PATH . " $img_path";
	$img_info = explode(" ", exec($command));
	$dimensions = explode("x",$img_info[2]);

	$isSquare = $dimensions[0] == $dimensions[1];

	if($isSquare)
	{
		d("The image is square, so we're returning");
		echo '1';
		return;
	}

	// This can potentially be improved ... a lot
	$command = IMAGEMAGICK_PATH . " $img_path -thumbnail x200 -resize '200x<' -resize 50% -gravity center -crop 100x100+0+0 +repage $img_path";

	d("Squaring image: $command");

	$output = exec($command);

	if($output == "")
		echo('1');
	else
	{
		d("ImageMagick Error: $output");
		echo($output);
	}
}