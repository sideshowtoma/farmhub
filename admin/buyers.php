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
        isset($_GET['re']) && !empty($_GET['re'])
                
                )
{
     
                $limit=trim($_GET['l']);
                $skip=trim($_GET['s']);
                $sort_column=trim($_GET['sc']);
                $sort_order=trim($_GET['so']);
                $rows_every=trim($_GET['re']);

                $action_page="buyers.php?l=".$limit."&s=".$skip."&sc=".$sort_column."&so=".$sort_order."&re=".$rows_every;//for form submission
                
               
                
                $action_page_without_page_name="l=".$limit."&s=".$skip."&sc=time_stamp&so=".$sort_order."&re=".$rows_every;//for form submission


                $full_link=$action_page;//for form submission
                $link_without_sort_column_sort_order="buyers.php?l=".$limit."&s=".$skip."&re=".$rows_every;//for headers sorting
                $link_without_limit_skip_rows_every="buyers.php?sc=".$sort_column."&so=".$sort_order;//for browsing

                //form submission
                if(isset($_POST['headers_is']) && !empty($_POST['headers_is']) &&
                         is_numeric($_POST['headers_is']) && 
                        isset($_POST['limit_is']) && !empty($_POST['limit_is']) && 
                        is_numeric($_POST['limit_is']) && 
                        ( $_POST['skip_is']==0 || is_numeric($_POST['skip_is']) ))
                {
                    $new_limit=trim($_POST['limit_is']);
                    $new_skip=trim($_POST['skip_is']);
                    $new_rows_every=trim($_POST['headers_is']);

                     header('location: '.$link_without_limit_skip_rows_every.'&l='.$new_limit.'&s='.$new_skip.'&re='.$new_rows_every.'&search_phrase='.$_POST['search_phrase'].' ');//redirect back to form correctly
                }
                
                
                                    //echo $_POST['id_or_passport'];
                    if(isset($_POST['telephone_number']) && !empty($_POST['telephone_number']) &&
                            isset($_POST['full_names']) && !empty($_POST['full_names'])&&
                            isset($_POST['new_password']) && !empty($_POST['new_password'])&&
                            isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])&&
                            isset($_POST['cost_per_crate']) && !empty($_POST['cost_per_crate'])&&
                            isset($_POST['cost_per_egg']) && !empty($_POST['cost_per_egg'])&&
                            isset($_POST['eggs_for_crate']) && !empty($_POST['eggs_for_crate'])

                            )

                    {
                        $vars='telephone_number='.$_POST['telephone_number'].
                                '&full_names='.$_POST['full_names'].
                                '&new_password='.$_POST['new_password'].
                                '&confirm_password='.$_POST['confirm_password'].
                                '&cost_per_crate='.$_POST['cost_per_crate'].
                                '&cost_per_egg='.$_POST['cost_per_egg'].
                                '&eggs_for_crate='.$_POST['eggs_for_crate'];
                             $returned_json_decoded= json_decode(send_curl_post(the_api_requests_url."user_create_buyer_user/",$vars,array("Customkey: ".$_SESSION['token_type']." ".$_SESSION['token'] )),true);//decode


                            if($returned_json_decoded["check"]==true)//if login is true
                            {

                                         header('location: '.$action_page.'&message='.$returned_json_decoded["message"].'&type=1');//

                            }
                            else//else failed
                            {

                                header('location: '.$action_page.'&message='.$returned_json_decoded["message"].'&type=2');//
                            }
                    }
                    
                    if(isset($_GET['active_status']) && !empty($_GET['active_status']) &&
                isset($_GET['_id']) && !empty($_GET['_id'])

                )
                {
                         $returned_json_decoded= json_decode(send_curl_post(the_api_requests_url."user_activate_user/",'active_status='.$_GET['active_status'].'&_id='.$_GET['_id'],array("Customkey: ".$_SESSION['token_type']." ".$_SESSION['token'] )),true);//decode


                        if($returned_json_decoded["check"]==true)//if login is true
                        {
                            
                          

                                     header('location: '.$action_page.'&message='.$returned_json_decoded["message"].'&type=1');//

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

    <title>Buyer</title>

	
        
  
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
    <input type="text" required name="telephone_number"   placeholder="telephone_number">
    <input type="text" required name="full_names"   placeholder="full_names">
    
    <?php
    $pass_to_use= rand(1000, 9999);
    ?>
    <input type="hidden" required name="new_password" value="<?php echo $pass_to_use?>"   >
    <input type="hidden" required name="confirm_password" value="<?php echo $pass_to_use?>"   >
    
    
    
    <input type="number" required name="cost_per_crate"   placeholder="cost_per_crate">
  <input type="number" required name="cost_per_egg"   placeholder="cost_per_egg">
  <input type="number" required name="eggs_for_crate"   placeholder="eggs_for_crate">
  
    
    
    <input type="submit" required value="Save" />
</form>
    <hr>
    <form method="POST" action="<?php echo $full_link;?>" id="browse_form" class="col s12">
                                            <select name="skip_is">
                                                <option value="<?php echo $skip;?>">Skip rows: <?php echo $skip;?></option>
                                                <?php
                                                $array_numbers_skip=array(0,10,50,100,250);
                                                foreach ($array_numbers_skip as $array_numbers_skip_value) 
                                                {
                                                    if($skip!=$array_numbers_skip_value)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $array_numbers_skip_value;?>">Skip rows: <?php echo $array_numbers_skip_value;?></option>
                                                        <?php
                                                    }
                                                    
                                                }
                                                ?>
                                                
                                            </select>
                                                
                                            <select name="limit_is">
                                                <option value="<?php echo $limit;?>">No. rows: <?php echo $limit;?></option>
                                                <?php
                                                $array_rows=array(10,50,100,250,500,1000);
                                                foreach ($array_rows as $array_rows_value) 
                                                {
                                                    if($limit!=$array_rows_value)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $array_rows_value;?>">No. rows: <?php echo $array_rows_value;?></option>
                                                        <?php
                                                    }
                                                    
                                                }
                                                ?>
                                                
                                            </select>
                                                
                                            <select name="headers_is">
                                                <option value="<?php echo $rows_every;?>">Headers: <?php echo $rows_every;?></option>
                                                <?php
                                                $array_headers=array(10,50,100);
                                                foreach ($array_headers as $array_headers_value) 
                                                {
                                                    if($rows_every!=$array_headers_value)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $array_headers_value;?>">Headers: <?php echo $array_headers_value;?></option>
                                                        <?php
                                                    }
                                                    
                                                }
                                                ?>
                                                
                                            </select>
                                           
                                            <input type="text" name="search_phrase" value="<?php echo $_GET['search_phrase']?>" size="50" placeholder="Search...">
                                             
                                            <input type="submit" value="GO" >
                                        </form>
    <hr>
    
    <table>
        <tr>
            <th>#</th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=telephone_number&so=<?php echo return_script_order($sort_column,$sort_order,"telephone_number")?>">Phone</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=full_names&so=<?php echo return_script_order($sort_column,$sort_order,"full_names")?>">Names</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=cost_per_crate&so=<?php echo return_script_order($sort_column,$sort_order,"cost_per_crate")?>">Cost per crate</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=cost_per_egg&so=<?php echo return_script_order($sort_column,$sort_order,"cost_per_egg")?>">Cost per egg</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=eggs_for_crate&so=<?php echo return_script_order($sort_column,$sort_order,"eggs_for_crate")?>">Eggs for crate</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=time_stamp&so=<?php echo return_script_order($sort_column,$sort_order,"time_stamp")?>">Time stamp</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=time_stamp&so=<?php echo return_script_order($sort_column,$sort_order,"time_stamp")?>">Status</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=time_stamp&so=<?php echo return_script_order($sort_column,$sort_order,"time_stamp")?>">Edit</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=time_stamp&so=<?php echo return_script_order($sort_column,$sort_order,"time_stamp")?>">Sales</a></th>
        </tr>
        <?php
    
                            $returned_json_decoded= json_decode(send_curl_post(the_api_requests_url."user_fetch_users/",'sort_by='.$sort_column.'&sort_order='.$sort_order.'&limit='.$limit.'&skip='.$skip.'&level=3&search_phrase='.$_GET['search_phrase'].'',array("Customkey: ".$_SESSION['token_type']." ".$_SESSION['token'] )),true);//decode


                            
                            if($returned_json_decoded["check"]==true)//if login is true
                            {

                                $row_counter=1;
                                foreach ($returned_json_decoded["message"] as $value) 
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $row_counter?></td>
                                        <td><?php echo $value['telephone_number']?></td>
                                        <td><?php echo $value['full_names']?></td>
                                        <td><?php echo number_format($value['cost_per_crate'],2)?></td>
                                        <td><?php echo number_format($value['cost_per_egg'],2)?></td>
                                        <td><?php echo number_format($value['eggs_for_crate'])?></td>
                                        <td><?php echo $value['time_stamp']?></td>
                                        <td>
                                            <?php
                                            if( $value['active_status']=="active")
                                            {
                                                ?>
                                                Active | <a href="<?php echo $action_page?>&active_status=inactive&_id=<?php echo $value['_id']?>" style="color: red">Inactivate</a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                Inactive | <a href="<?php echo $action_page?>&active_status=active&_id=<?php echo $value['_id']?>" style="color: green">Activate</a>
                                                <?php
                                            }
                                            ?>
                                            
                                        </td>
                                       
                                        <td><a href="buyer_edit.php?<?php echo $action_page_without_page_name?>&data=<?php echo base64_encode(json_encode($value))?>">Edit</a></td>
                                        <td><a href="buyer_sales.php?<?php echo $action_page_without_page_name?>&data=<?php echo base64_encode(json_encode($value))?>">Sales</a></td>
                                    </tr>
                                    <?php
                                    
                                    if($row_counter%$rows_every==0)
                                    {
                                        ?>
                                              <tr>
                                                    <th>#</th>
                                                    <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=telephone_number&so=<?php echo return_script_order($sort_column,$sort_order,"telephone_number")?>">Phone</a></th>
                                                    <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=full_names&so=<?php echo return_script_order($sort_column,$sort_order,"full_names")?>">Names</a></th>
                                                    <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=cost_per_crate&so=<?php echo return_script_order($sort_column,$sort_order,"cost_per_crate")?>">Cost per crate</a></th>
                                                    <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=cost_per_egg&so=<?php echo return_script_order($sort_column,$sort_order,"cost_per_egg")?>">Cost per egg</a></th>
                                                    <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=eggs_for_crate&so=<?php echo return_script_order($sort_column,$sort_order,"eggs_for_crate")?>">Eggs for crate</a></th>
                                                    <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=time_stamp&so=<?php echo return_script_order($sort_column,$sort_order,"time_stamp")?>">Time stamp</a></th>
                                                    <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=time_stamp&so=<?php echo return_script_order($sort_column,$sort_order,"time_stamp")?>">Status</a></th>
                                                    <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=time_stamp&so=<?php echo return_script_order($sort_column,$sort_order,"time_stamp")?>">Edit</a></th>
                                                    <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=time_stamp&so=<?php echo return_script_order($sort_column,$sort_order,"time_stamp")?>">Sales</a></th>
                                                </tr>
                                        <?php
                                    }
                                    $row_counter++;
                                }   

                            }
    ?>
    </table>
    
    
</body>




</html>
