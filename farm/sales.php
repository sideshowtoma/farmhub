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
 $personal_info=get_personal_info();
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

                $action_page="sales.php?l=".$limit."&s=".$skip."&sc=".$sort_column."&so=".$sort_order."&re=".$rows_every;//for form submission
                 $action_page_without_page_name="l=".$limit."&s=".$skip."&sc=".$sort_column."&so=".$sort_order."&re=".$rows_every;//for form submission
             
                  $full_link=$action_page;//for form submission
                $link_without_sort_column_sort_order="sales.php?l=".$limit."&s=".$skip."&re=".$rows_every;//for headers sorting
                $link_without_limit_skip_rows_every="sales.php?sc=".$sort_column."&so=".$sort_order;//for browsing

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
          
                 if(isset($_POST['user_id']) && !empty($_POST['user_id']) &&
                            isset($_POST['buyer_info']) && !empty($_POST['buyer_info'])&&
                            isset($_POST['units']) && !empty($_POST['units'])&&
                            isset($_POST['is_tray']) && !empty($_POST['is_tray'])&&
                            isset($_POST['date_added']) && !empty($_POST['date_added'])

                            )

                    {
                     $buyer_info_array=json_decode(base64_decode($_POST['buyer_info'],true),true);
                     
                    
                     if($_POST['is_tray']=="yes")
                     {
                         $cost_per_unit_are=$buyer_info_array['cost_per_crate'];
                     }
                     else
                     {
                          $cost_per_unit_are=$buyer_info_array['cost_per_egg'];
                     }
                        $vars='user_id='.$_POST['user_id'].
                                '&sold_to_user_id='.$buyer_info_array['_id'].
                                '&units='.$_POST['units'].
                                '&cost_per_unit='.$cost_per_unit_are.
                                '&is_tray='.$_POST['is_tray'].
                                '&date_added='.$_POST['date_added'].
                                '&cost_of_transport='.$_POST['cost_of_transport'];
                        // die(json_encode($vars));
                             $returned_json_decoded= json_decode(send_curl_post(the_api_requests_url."user_create_sale/",$vars,array("Customkey: ".$_SESSION['token_type']." ".$_SESSION['token'] )),true);//decode


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

    <title>Sales</title>

	
        
  
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
         
         <select required name="buyer_info">
            <option value="">Select buyer</option>
            
            <?php
            $returned_json_decoded_buyers= json_decode(send_curl_post(the_api_requests_url."user_fetch_users/",'sort_by=full_names&sort_order=DESC&limit=999999&skip=0&level=3&search_phrase=',array("Customkey: ".$_SESSION['token_type']." ".$_SESSION['token'] )),true);//decode

            if($returned_json_decoded_buyers['check']==true)
            {
                foreach ($returned_json_decoded_buyers['message'] as $value) 
                {
                    if($value['active_status']=='active')
                    {
                         ?>
                                <option value="<?php echo base64_encode(json_encode($value))?>"><?php echo $value['full_names']?></option>
                        <?php
                    }
                   
                }
            }
            ?>
           
        </select>
         
        <select required name="is_tray">
            <option value="">Select item</option>
            <option value="yes">Trays</option>
            <option value="no">Eggs</option>
            
           
        </select>
    <input type="number" required name="units"   placeholder="units" value="">
     <input type="number" required name="cost_of_transport"   placeholder="cost_of_transport" value="">
    <input type="date" required name="date_added"   placeholder="date" value="<?php echo storable_date_function(time()) ?>">
    
    
    <input type="hidden" required name="user_id" value="<?php echo $personal_info['user_id']?>"  >
    
    
    
   
    
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
                                           
                                        <input type="date" name="search_phrase" value="<?php echo $_GET['search_phrase']?>"  placeholder="Search...">
                                             
                                            <input type="submit" value="GO" >
                                        </form>
    <hr>
    
    
     <table>
        <tr>
            <th>#</th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=is_tray&so=<?php echo return_script_order($sort_column,$sort_order,"is_tray")?>">Sale item</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=units&so=<?php echo return_script_order($sort_column,$sort_order,"units")?>">Units</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=cost_per_unit&so=<?php echo return_script_order($sort_column,$sort_order,"cost_per_unit")?>">Cost per unit</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=cost_of_transport&so=<?php echo return_script_order($sort_column,$sort_order,"cost_of_transport")?>">Total cost</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=cost_of_transport&so=<?php echo return_script_order($sort_column,$sort_order,"cost_of_transport")?>">Cost of transport</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=time_stamp&so=<?php echo return_script_order($sort_column,$sort_order,"time_stamp")?>">Total revenue</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=time_stamp&so=<?php echo return_script_order($sort_column,$sort_order,"time_stamp")?>">To phone number</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=time_stamp&so=<?php echo return_script_order($sort_column,$sort_order,"time_stamp")?>">To full names</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=date_added&so=<?php echo return_script_order($sort_column,$sort_order,"date_added")?>">Date added</a></th>
        </tr>
        <?php
    
       // echo $_POST['search_phrase'];
                            $returned_json_decoded= json_decode(send_curl_post(the_api_requests_url."user_fetch_sales_user_from/",'sort_by='.$sort_column.'&sort_order='.$sort_order.'&limit='.$limit.'&skip='.$skip.'&user_id='.$personal_info["user_id"].'&search_phrase='.$_GET['search_phrase'].'',array("Customkey: ".$_SESSION['token_type']." ".$_SESSION['token'] )),true);//decode


                           // echo json_encode($returned_json_decoded);
                            
                            if($returned_json_decoded["check"]==true)//if login is true
                            {

                                $row_counter=1;
                                foreach ($returned_json_decoded["message"] as $value) 
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $row_counter?></td>
                                        <td><?php echo $value['is_tray']=="yes" ?"Trays" : "Eggs"; ?></td>
                                        <td><?php echo number_format($value['units'])?></td>
                                        <td><?php echo number_format($value['cost_per_unit'],2)?></td>
                                        <td><?php echo number_format($value['total_cost'],2)?></td>
                                        <td><?php echo number_format($value['cost_of_transport'],2)?></td>
                                        <td><?php echo number_format($value['total_revenue'],2)?></td>
                                        
                                        <td><?php echo $value['users_to_telephone_number']?></td>
                                        <td><?php echo $value['users_to_full_names']?></td>
                                        
                                        <td><?php echo $value['date_added']?></td>
                                       
                                       
                                    </tr>
                                    <?php
                                    
                                    if($row_counter%$rows_every==0)
                                    {
                                        ?>
                                             <tr>
                                                <th>#</th>
                                                <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=is_tray&so=<?php echo return_script_order($sort_column,$sort_order,"is_tray")?>">Sale item</a></th>
                                                <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=units&so=<?php echo return_script_order($sort_column,$sort_order,"units")?>">Units</a></th>
                                                <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=cost_per_unit&so=<?php echo return_script_order($sort_column,$sort_order,"cost_per_unit")?>">Cost per unit</a></th>
                                                <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=cost_of_transport&so=<?php echo return_script_order($sort_column,$sort_order,"cost_of_transport")?>">Total cost</a></th>
                                                <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=cost_of_transport&so=<?php echo return_script_order($sort_column,$sort_order,"cost_of_transport")?>">Cost of transport</a></th>
                                                <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=time_stamp&so=<?php echo return_script_order($sort_column,$sort_order,"time_stamp")?>">Total revenue</a></th>
                                                <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=time_stamp&so=<?php echo return_script_order($sort_column,$sort_order,"time_stamp")?>">To phone number</a></th>
                                                <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=time_stamp&so=<?php echo return_script_order($sort_column,$sort_order,"time_stamp")?>">To full names</a></th>
                                                <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=date_added&so=<?php echo return_script_order($sort_column,$sort_order,"date_added")?>">Date added</a></th>
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
