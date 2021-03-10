<?php
require '../classes/sessions.php';
require '../classes/constants.php';
require '../classes/functions.php';



//echo $_SESSION['session_id'].'---'.$_SESSION['cookie'];
if(loggedin() && !empty($_SESSION['token']) && !empty($_SESSION['token']) && !empty($_SESSION['token_type']) && !empty($_SESSION['token_type']) )//if logged in and user_id session is not empty
{
			
}
else
{
    session_destroy();		
    header('location: ../ ');	
}

if(isset($_GET['message']) && !empty($_GET['message']) && isset($_GET['type']) && !empty($_GET['type']))
{
	$message=$_GET['message'];
        $type=$_GET['type'];
        $good_bad_id=$type==1? 'good_upload_message': 'bad_upload_message';
	$message='<span class="'.$good_bad_id.'">'.$message.'</span>';
}
        
//check login

//echo $_POST['id_or_passport'];
if(isset($_POST['old_password']) && !empty($_POST['old_password']) &&
        isset($_POST['new_password']) && !empty($_POST['new_password'])&&
        isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])
        
        )
{
	 $returned_json_decoded= json_decode(send_curl_post(the_api_requests_url."user_change_password/",'old_password='.$_POST['old_password'].'&new_password='.$_POST['new_password'].'&confirm_password='.$_POST['confirm_password'],array("Customkey: ".$_SESSION['token_type']." ".$_SESSION['token'] )),true);//decode
        
        
        if($returned_json_decoded["check"]==true)//if login is true
        {
           
                     header('location: ../?message='.$returned_json_decoded["message"].'&type=1');//
         
        }
        else//else failed
        {
            
            header('location: changepassword.php?message='.$returned_json_decoded["message"].'&type=2');//
        }
}

?>
  
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Change password</title>

	
        
  
</head>
<body>

      <a href="../admin/"  >Home</a>
    <a href="buyers.php?l=50&s=0&sc=time_stamp&so=DESC&re=10"  >Buyers</a>
    <a href="farm_workers.php?l=50&s=0&sc=time_stamp&so=DESC&re=10"  >Farm Workers</a>
    <a href="inventory.php?l=50&s=0&sc=time_stamp&so=DESC&re=10"  >Inventory</a>
    <a href="production.php?l=50&s=0&sc=time_stamp&so=DESC&re=10"  >Production</a>
    <a href="sales.php?l=50&s=0&sc=time_stamp&so=DESC&re=10"  >Sales</a>
    <a href="personalinformation.php"  >Personal information</a>
    <a href="changepassword.php"  >Change password</a>
    <a href="../logout.php"  >Logout</a>



<?php echo $message?>
<form method="POST">
    <input type="password" required name="old_password"   placeholder="Current pin">
    <input type="password" required name="new_password" placeholder="New pin"   >
    <input type="password" required name="confirm_password" placeholder="Confirm pin"   >
    <input type="submit" required value="Save" />
</form>
</body>




</html>
