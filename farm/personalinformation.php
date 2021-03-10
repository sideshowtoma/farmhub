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
?>
  
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Personal information</title>

	
        
  
</head>
<body>

  <a href="../farm/"  >Home</a>
    <a href="inventory.php?l=50&s=0&sc=time_stamp&so=DESC&re=10"  >Inventory</a>
    <a href="production.php?l=50&s=0&sc=time_stamp&so=DESC&re=10"  >Production</a>
    <a href="sales.php?l=50&s=0&sc=time_stamp&so=DESC&re=10"  >Sales</a>
    <a href="personalinformation.php"  >Personal information</a>
    <a href="changepassword.php"  >Change password</a>
    <a href="../logout.php"  >Logout</a>
    
    



<?php echo $message?>
<?php

       
       
       
       
        $returned_json_decoded= json_decode(send_curl_post(the_api_requests_url."user_get_info/",'',array("Customkey: ".$_SESSION['token_type']." ".$_SESSION['token'] )),true);//decode
        
        //echo json_encode($returned_json_decoded);
        if($returned_json_decoded["check"]==true)//if login is true
        {
             
            ?>
                <table>
                    <tr>
                        <th>telephone_number</th>
                        <td><?php echo $returned_json_decoded["message"]["telephone_number"]?></td>
                    </tr>
                    <tr>
                        <th>full_names</th>
                        <td><?php echo $returned_json_decoded["message"]["full_names"]?></td>
                    </tr>
                   
                    <tr>
                        <th>user_active</th>
                        <td><?php echo $returned_json_decoded["message"]["user_active"]?></td>
                    </tr>
                    <tr>
                        <th>Number of lines</th>
                        <td><?php echo number_format($returned_json_decoded["message"]["number_of_line"])?></td>
                    </tr>
                    <tr>
                        <th>Time stamp</th>
                        <td><?php echo $returned_json_decoded["message"]["user_time_stamp"]?></td>
                    </tr>
                </table>

                   
               
            
            <?php
                         
                    
         
        }
?>
</body>




</html>
