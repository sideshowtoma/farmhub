
<?php
require './classes/sessions.php';
require './classes/constants.php';
require './classes/functions.php';

//setting edit message
if(isset($_GET['message']) && !empty($_GET['message']) && isset($_GET['type']) && !empty($_GET['type']))
{
	$message=$_GET['message'];
        $type=$_GET['type'];
        $good_bad_id=$type==1? 'good_upload_message': 'bad_upload_message';
	$message='<span class="'.$good_bad_id.'">'.$message.'</span>';
}

if(isset($_POST['telephone_number']) && !empty($_POST['telephone_number']) && isset($_POST['password']) && !empty($_POST['password']))
{
	$telephone_number=  ($_POST['telephone_number']);
        $password=  $_POST['password'];
        
        $url_is=the_api_requests_url."user_login/";
        
        $myvars='telephone_number='.$telephone_number.'&password='.$password;
        
        $header_array= array();
       
        $returned_json=send_curl_post($url_is,$myvars,$header_array);//cap output
        
        //die($returned_json);
       
        $returned_json_decoded= json_decode($returned_json,true);//decode
        
        $check_is=$returned_json_decoded["check"];//check
        
        if($check_is==true)//if login is true
        {
             $_SESSION['token']=$returned_json_decoded["token"];
             $_SESSION['token_type']=$returned_json_decoded["token_type"];
                                                
             switch ($returned_json_decoded["type"]) 
             {
                        case 1:
                            header('location: ./admin/');//
                        break;
                        
                        case 2:
                            header('location: ./farm/');//
                        break;
                        
                      
                   
                        default:
                            header('location: ./?message=Wrong phone number pin combination&type=2');//
                        break;
             }
                         
                    
         
        }
        else//else failed
        {
            
           header('location: ./?message=Wrong phone number pin combination&type=2');//
        }
}


//check login
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login</title>
   
</head>

<body>
  <?php echo $message;?>
                            <form method="post">


                                <input type="text" required name="telephone_number" placeholder="Telephone number"  />



                                <input type="password" required name="password"  placeholder="Pin" />

                               
                              
                                    <input value="Log In" type="submit">
                                                         
										
                                
                            </form>

</body>

</html>
