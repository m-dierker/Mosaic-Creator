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

error_reporting(E_ALL | E_STRICT);

require('upload.class.php');
require('../../functions.php');

$user = getFacebookUser();

d("Upload PHP - $user");

if($user == 0)
{
    $user_ip = $_SERVER['REMOTE_ADDR'];
    d("Hacking attempt on the upload plugin index from $user_ip");
    die('hacking attempt');
}


$upload_dir = dirname(__FILE__) . "/user-files/$user/files/";


d("Upload Directory: $upload_dir");

$upload_handler = new UploadHandler(array(

    'upload_dir' => $upload_dir

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
    d("get");
        $upload_handler->get();
        break;
    case 'POST':
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
            d("delete");
            $upload_handler->delete();
        } else {
            d("post");
            
            if(!is_dir($upload_dir))
                mkdir($upload_dir, 0777, true);


            $upload_handler->post();
        }
        break;
    case 'DELETE':
    d("delete1");
        $upload_handler->delete();
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');
}
