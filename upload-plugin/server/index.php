<?php
/*
 * jQuery File Upload Plugin PHP Example 5.7
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

// error_reporting(E_ALL | E_STRICT);
error_reporting(0);

require('upload.class.php');
require('../../functions.php');

$user = getFacebookUser();

if($user == 0)
{
    $user_ip = $_SERVER['REMOTE_ADDR'];
    d("Hacking attempt on the upload plugin index from $user_ip");
    die('hacking attempt');
}

$user_dir = dirname(__FILE__) . "/user-files/$user";
$user_url = 'http://' . $_SERVER['SERVER_NAME']  . "/upload-plugin/server/user-files/$user"; //finish me

$upload_dir = "$user_dir/files/";
$upload_url = "$user_url/files/";

$thumbnail_dir = "$user_dir/thumbnails/";
$thumbnail_url = "$user_url/thumbnails/";

$upload_handler = new UploadHandler(array(

    'upload_dir' => $upload_dir,
    'upload_url' => $upload_url,

    'image_versions' => array(

        'thumbnail' => array(
                    'upload_dir' => $thumbnail_dir,
                    'upload_url' => $thumbnail_url,
        )
    )

    ));

header('Pragma: no-cache');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Content-Disposition: inline; filename="files.json"');
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        break;
    case 'HEAD':
    case 'GET':
        $upload_handler->get();
        break;
    case 'POST':
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
            $upload_handler->delete();
        } else {
            
            if(!is_dir($upload_dir))
                mkdir($upload_dir, 0755, true);

            if(!is_dir($thumbnail_dir))
                mkdir($thumbnail_dir, 0755, true);


            $upload_handler->post();
        }
        break;
    case 'DELETE':
        $upload_handler->delete();
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');
}
