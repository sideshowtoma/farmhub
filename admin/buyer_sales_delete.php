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
                $sale_data= json_decode(base64_decode($_GET['data_1'],true),true);

                $full_link="buyer_sales_delete.php?l=".$limit."&s=".$skip."&sc=".$sort_column."&so=".$sort_order."&re=".$rows_every."&data=".$_GET['data']."&data_1=".$_GET['data_1'];//for form submission
               $return_link="buyer_sales.php?l=".$limit."&s=".$skip."&sc=".$sort_column."&so=".$sort_order."&re=".$rows_every."&data=".$_GET['data'];//for form submission
                 $action_page_without_page_name="l=".$limit."&s=".$skip."&sc=".$sort_column."&so=".$sort_order."&re=".$rows_every."&data=".$_GET['data']."&data_1=".$_GET['data_1'];//for form submission
             
         $statement='Are you sure you want to remove the sale of revenue '.strtoupper(number_format($sale_data['total_revenue'],2)).'? <span><a href="'.$full_link.'&a=yes" style="color:red">[YES]</a></span>  &nbsp;&nbsp;&nbsp;&nbsp;  <span ><a href="'.$return_link.'" style="color:green">[NO]</a></span> ';
     
                
                    if(isset($_GET['a']) && !empty($_GET['a']) )
                    {
                        //echo($_GET['a']);
                        $answer=  strtolower(trim($_GET['a']));
                        if($answer=="yes")
                        {
                            //delete
                            $returned_json_decoded= json_decode(send_curl_post(the_api_requests_url."user_remove_sale/",'_id='.$sale_data['_id'],array("Customkey: ".$_SESSION['token_type']." ".$_SESSION['token'] )),true);//decode
        

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

    <title>Buyer sales delete</title>

	
        
  
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
                        <th>Eggs for crate</th>
                        <td><?php echo number_format($user_data["eggs_for_crate"])?></td>
                    </tr>
                    <tr>
                        <th>Cost per crate</th>
                        <td><?php echo number_format($user_data["cost_per_crate"],2)?></td>
                    </tr>
                    <tr>
                        <th>Cost per egg</th>
                        <td><?php echo number_format($user_data["cost_per_egg"],2)?></td>
                    </tr>
                </table>

    <hr>
    
    
   <?php echo $statement?>
    
    

    
</body>




</html>