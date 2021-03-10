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
        isset($_GET['data']) && !empty($_GET['data'])&&
        isset($_GET['data_1']) && !empty($_GET['data_1'])
                
                )
{
     
                $limit=trim($_GET['l']);
                $skip=trim($_GET['s']);
                $sort_column=trim($_GET['sc']);
                $sort_order=trim($_GET['so']);
                $rows_every=trim($_GET['re']);
                $user_data= json_decode(base64_decode($_GET['data'],true),true);
                $eggs_data= json_decode(base64_decode($_GET['data_1'],true),true);

                $action_page="farm_workers_production_edit.php?l=".$limit."&s=".$skip."&sc=".$sort_column."&so=".$sort_order."&re=".$rows_every."&data=".$_GET['data']."&data_1=".$_GET['data_1'];//for form submission
               $return_page="farm_workers_production.php?l=".$limit."&s=".$skip."&sc=".$sort_column."&so=".$sort_order."&re=".$rows_every."&data=".$_GET['data'];//for form submission
                 $action_page_without_page_name="l=".$limit."&s=".$skip."&sc=".$sort_column."&so=".$sort_order."&re=".$rows_every."&data=".$_GET['data']."&data_1=".$_GET['data_1'];//for form submission
             
          if(isset($_POST['user_id']) && !empty($_POST['user_id']) &&
                            isset($_POST['line_description']) && !empty($_POST['line_description'])&&
                            isset($_POST['_id']) && !empty($_POST['_id'])&&
                            isset($_POST['date_collected']) && !empty($_POST['date_collected'])

                            )

                    {
                        $vars='user_id='.$_POST['user_id'].
                                '&line_description='.$_POST['line_description'].
                                '&big_eggs='.$_POST['big_eggs'].
                                '&small_eggs='.$_POST['small_eggs'].
                                '&broken_eggs='.$_POST['broken_eggs'].
                                '&date_collected='.$_POST['date_collected'].
                                '&_id='.$_POST['_id'];
                             $returned_json_decoded= json_decode(send_curl_post(the_api_requests_url."user_edit_egg_collection/",$vars,array("Customkey: ".$_SESSION['token_type']." ".$_SESSION['token'] )),true);//decode


                            if($returned_json_decoded["check"]==true)//if login is true
                            {

                                         header('location: '.$return_page.'&message='.$returned_json_decoded["message"].'&type=1');//

                            }
                            else//else failed
                            {

                              header('location: '.$action_page.'&message='.$returned_json_decoded["message"].'&type=2');//
                            }
                    }
               
 }


?>
  
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Farm worker production edit</title>

	
        
  
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
                        <td><?php echo $user_data["telephone_number"]?></td>
                    </tr>
                    <tr>
                        <th>full_names</th>
                        <td><?php echo $user_data["full_names"]?></td>
                    </tr>
                  
                    <tr>
                        <th>user_active</th>
                        <td><?php echo $user_data["active_status"]?></td>
                    </tr>
                    <tr>
                        <th>Time stamp</th>
                        <td><?php echo $user_data["time_stamp"]?></td>
                    </tr>
                    <tr>
                        <th>Number of lines</th>
                        <td><?php echo number_format($user_data["number_of_line"])?></td>
                    </tr>
                </table>

    <hr>
    
    
    <form method="POST">
        <input type="text" required name="line_description"   placeholder="line_description" value="<?php echo $eggs_data['line_description']?>">  
    <input type="number" required name="big_eggs"   placeholder="big_eggs" value="<?php echo $eggs_data['big_eggs']?>">
    <input type="number" required name="small_eggs"   placeholder="small_eggs" value="<?php echo $eggs_data['small_eggs']?>">
    <input type="number" required name="broken_eggs"   placeholder="broken_eggs" value="<?php echo $eggs_data['broken_eggs']?>">
    <input type="date" required name="date_collected"   placeholder="date_collected" value="<?php echo UTCTimeToLocalTime($eggs_data['date_collected'], '', 'd-m-Y', 'Y-m-d') ?>">
    
    
    <input type="hidden" required name="_id" value="<?php echo $eggs_data['_id']?>"  >
   <input type="hidden" required name="user_id" value="<?php echo $eggs_data['users_id']?>"  >
    
    
    
   
    
    <input type="submit" required value="Save" />
</form>
    
    

    
</body>




</html>
