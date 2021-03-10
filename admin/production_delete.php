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

 if(
                 isset($_GET['l']) && is_numeric($_GET['l']) && 
        ( $_GET['s']==0 || is_numeric($_GET['s']) ) &&  
        isset($_GET['sc']) && !empty($_GET['sc']) &&
        isset($_GET['so']) && !empty($_GET['so']) &&
        isset($_GET['re']) && !empty($_GET['re'])&&
        isset($_GET['data']) && !empty($_GET['data'])
                
                )
{
     
                $limit=trim($_GET['l']);
                $skip=trim($_GET['s']);
                $sort_column=trim($_GET['sc']);
                $sort_order=trim($_GET['so']);
                $rows_every=trim($_GET['re']);
                
                $eggs_data= json_decode(base64_decode($_GET['data'],true),true);

                $full_link="production_delete.php?l=".$limit."&s=".$skip."&sc=".$sort_column."&so=".$sort_order."&re=".$rows_every."&data=".$_GET['data'];//for form submission
               $return_link="production.php?l=".$limit."&s=".$skip."&sc=".$sort_column."&so=".$sort_order."&re=".$rows_every;//for form submission
                 $action_page_without_page_name="l=".$limit."&s=".$skip."&sc=".$sort_column."&so=".$sort_order."&re=".$rows_every."&data=".$_GET['data'];//for form submission
             
                  $statement='Are you sure you want to remove the entry for eggs collected on '.strtoupper($eggs_data['date_collected']).'? <span><a href="'.$full_link.'&a=yes" style="color:red">[YES]</a></span>  &nbsp;&nbsp;&nbsp;&nbsp;  <span ><a href="'.$return_link.'" style="color:green">[NO]</a></span> ';
     
                
                    if(isset($_GET['a']) && !empty($_GET['a']) )
                    {
                        //echo($_GET['a']);
                        $answer=  strtolower(trim($_GET['a']));
                        if($answer=="yes")
                        {
                            //delete
                            $returned_json_decoded= json_decode(send_curl_post(the_api_requests_url."user_remove_egg_collection/",'_id='.$eggs_data['_id'],array("Customkey: ".$_SESSION['token_type']." ".$_SESSION['token'] )),true);//decode
        

                                        if($returned_json_decoded["check"]==true)//if check is true
                                        {

                                             header('location: '.$return_link.'&message='.$returned_json_decoded["message"].'&type=1');//
                                        }
                                        else//else failed
                                        {

                                            header('location: '.$return_link.'&message='.$returned_json_decoded["message"].'&type=2');//
                                        } 
                        }
                        else
                        {
                             header('location: '.$return_link);//
                        }
                    }
        
 }


?>
  
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Production delete</title>

	
        
  
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
    
    <table>
                    <tr>
                        <th>telephone_number</th>
                        <td><?php echo $eggs_data["users_telephone_number"]?></td>
                    </tr>
                    <tr>
                        <th>full_names</th>
                        <td><?php echo $eggs_data["users_full_names"]?></td>
                    </tr>
                  
                 
                </table>

    <hr>
    
    <?php echo $statement?>
  
    
    

    
</body>




</html>
