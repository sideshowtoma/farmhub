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

                $action_page="production.php?l=".$limit."&s=".$skip."&sc=".$sort_column."&so=".$sort_order."&re=".$rows_every;//for form submission
                 $action_page_without_page_name="l=".$limit."&s=".$skip."&sc=".$sort_column."&so=".$sort_order."&re=".$rows_every;//for form submission
             
                  $full_link=$action_page;//for form submission
                $link_without_sort_column_sort_order="production.php?l=".$limit."&s=".$skip."&re=".$rows_every;//for headers sorting
                $link_without_limit_skip_rows_every="production.php?sc=".$sort_column."&so=".$sort_order;//for browsing

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
                            isset($_POST['line_description']) && !empty($_POST['line_description'])&&
                            isset($_POST['date_collected']) && !empty($_POST['date_collected'])

                            )

                    {
                        $vars='user_id='.$_POST['user_id'].
                                '&line_description='.$_POST['line_description'].
                                '&big_eggs='.$_POST['big_eggs'].
                                '&small_eggs='.$_POST['small_eggs'].
                                '&broken_eggs='.$_POST['broken_eggs'].
                                '&date_collected='.$_POST['date_collected'];
                             $returned_json_decoded= json_decode(send_curl_post(the_api_requests_url."user_create_egg_collection/",$vars,array("Customkey: ".$_SESSION['token_type']." ".$_SESSION['token'] )),true);//decode


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

    <title>Production</title>

	
        
  
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
    
      <form method="POST">
          <select name="line_description" required>
              <option value="">Select line</option>
              <?php
              for ($index = 0; $index < $personal_info['number_of_line']; $index++) 
              {
                ?>
                <option value="Line <?php echo ($index+1)?>">Line <?php echo ($index+1)?></option>
                <?php
              }
              ?>
          </select>
           <input type="number" required name="big_eggs"   placeholder="big_eggs" >
    <input type="number" required name="small_eggs"   placeholder="small_eggs" >
    <input type="number" required name="broken_eggs"   placeholder="broken_eggs">
    <input type="date" required name="date_collected"   placeholder="date_collected" value="<?php echo storable_date_function(time()) ?>">
    
    
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
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=line_description&so=<?php echo return_script_order($sort_column,$sort_order,"line_description")?>">Line</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=big_eggs&so=<?php echo return_script_order($sort_column,$sort_order,"big_eggs")?>">Big eggs</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=small_eggs&so=<?php echo return_script_order($sort_column,$sort_order,"small_eggs")?>">Small eggs</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=broken_eggs&so=<?php echo return_script_order($sort_column,$sort_order,"broken_eggs")?>">Broken eggs</a></th>
            <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=date_collected&so=<?php echo return_script_order($sort_column,$sort_order,"date_collected")?>">Date collected</a></th>
        </tr>
        <?php
    
       // echo $_POST['search_phrase'];
                            $returned_json_decoded= json_decode(send_curl_post(the_api_requests_url."user_fetch_egg_collections_user_id/",'sort_by='.$sort_column.'&sort_order='.$sort_order.'&limit='.$limit.'&skip='.$skip.'&user_id='.$personal_info["user_id"].'&search_phrase='.$_GET['search_phrase'].'',array("Customkey: ".$_SESSION['token_type']." ".$_SESSION['token'] )),true);//decode


                           // echo json_encode($returned_json_decoded);
                            
                            if($returned_json_decoded["check"]==true)//if login is true
                            {

                                $row_counter=1;
                                foreach ($returned_json_decoded["message"] as $value) 
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $row_counter?></td>
                                        <td><?php echo $value['line_description'] ?></td>
                                        <td><?php echo number_format($value['big_eggs'])?></td>
                                        <td><?php echo number_format($value['small_eggs'])?></td>
                                        <td><?php echo number_format($value['broken_eggs'])?></td>
                                        
                                        <td><?php echo $value['date_collected']?></td>
                                       
                                       
                                    </tr>
                                    <?php
                                    
                                    if($row_counter%$rows_every==0)
                                    {
                                        ?>
                                              <tr>
                                                    <th>#</th>
                                                    <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=line_description&so=<?php echo return_script_order($sort_column,$sort_order,"line_description")?>">Line</a></th>
                                                    <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=big_eggs&so=<?php echo return_script_order($sort_column,$sort_order,"big_eggs")?>">Big eggs</a></th>
                                                    <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=small_eggs&so=<?php echo return_script_order($sort_column,$sort_order,"small_eggs")?>">Small eggs</a></th>
                                                    <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=broken_eggs&so=<?php echo return_script_order($sort_column,$sort_order,"broken_eggs")?>">Broken eggs</a></th>
                                                    <th><a href="<?php echo $link_without_sort_column_sort_order?>&sc=date_collected&so=<?php echo return_script_order($sort_column,$sort_order,"date_collected")?>">Date collected</a></th>
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
