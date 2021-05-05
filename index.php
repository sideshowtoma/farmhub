
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
   
   <style>

* { box-sizing:border-box; }

body {
	font-family: Helvetica;
	background: #eee;
  -webkit-font-smoothing: antialiased;
}

hgroup { 
	text-align:center;
	margin-top: 4em;
    
}

h1 { font-weight: 700; font-size: 78px; }
h3 { font-weight: 300; font-size: 48px; }

h1 { color: #636363; }

h3 { color: #4a89dc; }

form {
	width: 80%;
	margin: 4em auto;
	padding: 3em 2em 2em 2em;
	background: #fafafa;
	border: 1px solid #ebebeb;
	box-shadow: rgba(0,0,0,0.14902) 0px 1px 1px 0px,rgba(0,0,0,0.09804) 0px 1px 2px 0px;
}

.group { 
	position: relative; 
	margin-bottom: 45px; 
}

input {
	font-size: 68px;
	padding: 10px 10px 10px 5px;
	-webkit-appearance: none;
	display: block;
	background: #fafafa;
	color: #636363;
	width: 100%;
	border: none;
	border-radius: 0;
	border-bottom: 1px solid #757575;
}

input:focus { outline: none; }


/* Label */

label {
	color: #999; 
	font-size: 18px;
	font-weight: normal;
	position: absolute;
	pointer-events: none;
	left: 5px;
	top: 10px;
	transition: all 0.2s ease;
}


/* active */

input:focus ~ label, input.used ~ label {
	top: -20px;
  transform: scale(.75); left: -2px;
	/* font-size: 14px; */
	color: #4a89dc;
}


/* Underline */

.bar {
	position: relative;
	display: block;
	width: 100%;
}

.bar:before, .bar:after {
	content: '';
	height: 2px; 
	width: 0;
	bottom: 1px; 
	position: absolute;
	background: #4a89dc; 
	transition: all 0.2s ease;
}

.bar:before { left: 50%; }

.bar:after { right: 50%; }


/* active */

input:focus ~ .bar:before, input:focus ~ .bar:after { width: 50%; }


/* Highlight */

.highlight {
	position: absolute;
	height: 60%; 
	width: 100px; 
	top: 25%; 
	left: 0;
	pointer-events: none;
	opacity: 0.5;
}


/* active */

input:focus ~ .highlight {
	animation: inputHighlighter 0.3s ease;
}


/* Animations */

@keyframes inputHighlighter {
	from { background: #4a89dc; }
	to 	{ width: 0; background: transparent; }
}


/* Button */

.button {
  position: relative;
  display: inline-block;
  padding: 50px 64px;
  margin: .3em 0 1em 0;
  width: 100%;
  vertical-align: middle;
  color: #fff;
  font-size: 68px;
  line-height: 20px;
  -webkit-font-smoothing: antialiased;
  text-align: center;
  letter-spacing: 1px;
  background: transparent;
  border: 0;
  border-bottom: 2px solid #3160B6;
  cursor: pointer;
  transition: all 0.15s ease;
}
.button:focus { outline: 0; }


/* Button modifiers */

.buttonBlue {
  background: #4a89dc;
  text-shadow: 1px 1px 0 rgba(39, 110, 204, .5);
}

.buttonBlue:hover { background: #357bd8; }


/* Ripples container */

.ripples {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  background: transparent;
}


/* Ripples circle */

.ripplesCircle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  opacity: 0;
  width: 0;
  height: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.25);
}

.ripples.is-active .ripplesCircle {
  animation: ripples .4s ease-in;
}


/* Ripples animation */

@keyframes ripples {
  0% { opacity: 0; }

  25% { opacity: 1; }

  100% {
    width: 200%;
    padding-bottom: 200%;
    opacity: 0;
  }
}

footer { text-align: center; }

footer p {
	color: #888;
	font-size: 13px;
	letter-spacing: .4px;
}

footer a {
	color: #4a89dc;
	text-decoration: none;
	transition: all .2s ease;
}

footer a:hover {
	color: #666;
	text-decoration: underline;
}

footer img {
	width: 80px;
	transition: all .2s ease;
}

footer img:hover { opacity: .83; }

footer img:focus , footer a:focus { outline: none; }









   </style>


</head>

<body>

<div class="row">
            <div class="col-md-12">
              <div class="card">

              <div class="card-body">
  
  <br><br><br>


  <hgroup>
  <h1>Farm Hub</h1>
  <h3>By Clicksoft Kenya</h3>
</hgroup>
                            <form method="post">
                            <?php echo $message;?>
                            <div class="group"> 

                                <input type="number"   required name="telephone_number" placeholder="Phone Number"  /> 
                                <span class="highlight"></span><span class="bar"></span>
                              
                            </div> 
                            <div class="group"> 
                                <input type="number"  required name="password" placeholder="Pin"   />
                                <span class="highlight"></span><span class="bar"></span>
                              
                                </div> 
                              
                                <button type="submit" class="button buttonBlue">Login
    <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
  </button>
                                
                            </form>

                            </div>
                            </div>
                            </div>
                            </div>

<script>

$(window, document, undefined).ready(function() {

$('input').blur(function() {
  var $this = $(this);
  if ($this.val())
    $this.addClass('used');
  else
    $this.removeClass('used');
});

var $ripples = $('.ripples');

$ripples.on('click.Ripples', function(e) {

  var $this = $(this);
  var $offset = $this.parent().offset();
  var $circle = $this.find('.ripplesCircle');

  var x = e.pageX - $offset.left;
  var y = e.pageY - $offset.top;

  $circle.css({
    top: y + 'px',
    left: x + 'px'
  });

  $this.addClass('is-active');

});

$ripples.on('animationend webkitAnimationEnd mozAnimationEnd oanimationend MSAnimationEnd', function(e) {
    $(this).removeClass('is-active');
});

});



</script>


</body>

</html>
