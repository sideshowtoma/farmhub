<?php
ob_start();//output buffer for the
session_start();// initiating session
//$current_file=$_SERVER['SCRIPT_NAME'];

if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
{
$http_referer=$_SERVER['HTTP_REFERER'];
}//setting the referer for redirection on logout




function loggedin()//fuction to check if a session is set if not false is returned otherwise a true
{
	if(isset($_SESSION['token']) && !empty($_SESSION['token']) && isset($_SESSION['token_type']) && !empty($_SESSION['token_type'])) 
	{
		return true;
	}
	else 
	{
		return false;
	}
}



