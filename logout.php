<?php
require './classes/sessions.php';
require './classes/constants.php';
require './classes/functions.php';

//echo $http_referer;// show the page where the reference is from
$message=trim($_GET['message']);
$type=trim($_GET['type']);

session_destroy();// kill the session
 
header('Location: ./?message='.$message.'&type='.$type.'');//return to where previous reference was from


