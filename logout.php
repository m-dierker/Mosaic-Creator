<?php

// We need to make sure the Facebook PHP session expires too

require('functions.php');

try
{
	$facebook = getFacebookObject();
    $facebook->destroySession();
}
catch (FacebookRestClientException $e)
{
    //you'll want to catch this
    //it fails all the time
}
