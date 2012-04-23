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
	sleep(1);
	echo('1');
}