<?php

 //return datetime
function storable_datetime_function($time)
{
            date_default_timezone_set(time_zone_format);//make time kenyan
            $my_day= date('Y-m-d H:i:s',$time);
            
            return $my_day;
            
}

function storable_datetime_proper_function($time)
{
            date_default_timezone_set(time_zone_format);//make time kenyan
            $my_day= date('d-m-Y H:i:s',$time);
            
            return $my_day;
            
}

function storable_datetime_html_function($time)
{
            date_default_timezone_set(time_zone_format);//make time kenyan
            $my_day= date('Y-m-dTH:i',$time);
            
            return $my_day;
            
}

function storable_date_function($time)
{
            date_default_timezone_set(time_zone_format);//make time kenyan
            $my_day= date('Y-m-d',$time);
            
            return $my_day;
            
}

function storable_date_usable_function($time)
{
            date_default_timezone_set(time_zone_format);//make time kenyan
            $my_day= date('d/m/Y',$time);
            
            return $my_day;
            
}

 //return time
function storable_time24hr_function($time)
{
            date_default_timezone_set(time_zone_format);//make time kenyan
            $my_day= date('H:i',$time);
            
            return $my_day;
            
}

 //return time
function storable_year_only_function($time)
{
            date_default_timezone_set(time_zone_format);//make time kenyan
            $my_day= date('Y',$time);
            
            return $my_day;
            
}

 function UTCTimeToLocalTime($time, $tz = '', $FromDateFormat = 'Y-m-d H:i:s', $ToDateFormat = 'H:i:s d-m-Y')
{
    
if ($tz == '')
{
   $tz = time_zone_format; 
}
    
 
$utc_datetime = DateTime::createFromFormat($FromDateFormat, $time, new
    DateTimeZone('UTC'));
$local_datetime = $utc_datetime;
//die(time_zone_format);
$local_datetime->setTimeZone(new DateTimeZone($tz));
return $local_datetime->format($ToDateFormat);
}

function send_curl_post($url,$myvars,$header_array,$post=1)
{
   
    
   
    
     $ch = curl_init( $url );//initialize response
            
    //die($myvars);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);//ignore sign in
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false);//ignore sign in
        curl_setopt( $ch, CURLOPT_POST, $post);//as post
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);//set fields
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array); 
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );//true to url
        curl_setopt( $ch, CURLOPT_HEADER, 0 );//header null
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);//catch the response
        
        
       
        return curl_exec($ch);
    
}



function get_personal_info()
{
    return $returned_json_decoded= json_decode(send_curl_post(the_api_requests_url."user_get_info/",'',array("Customkey: ".$_SESSION['token_type']." ".$_SESSION['token'] )),true)['message'];//decode
       
}





function add_three_dots_to_string_after_size($string)
{
    //$explode= explode('', $string);
    
    $explode= str_split( $string);
    $return_string='';
    
    $max=count($explode)<max_string_size_for_show ? count($explode) : max_string_size_for_show;
    
    for ($index = 0; $index < $max; $index++) {
        $return_string.=$explode[$index];
        
    }
    
    return $return_string.'...';
}

 function get_months_array($year_is)
{
    //months
        $array_query_months=array();
        //$year_is=storable_year_only_function(time());
        $jan_start=$year_is.'-01-01';
        $jan_end=$year_is.'-01-31';
        $array_query_months[0]=array('start_date'=>$jan_start,'end_date'=>$jan_end);
        
        $feb_start=$year_is.'-02-01';
        $feb_end=validateDate($year_is.'-02-29','Y-m-d')==true ? $year_is.'-02-29' : $year_is.'-02-28';//feb fix
        $array_query_months[1]=array('start_date'=>$feb_start,'end_date'=>$feb_end);
        
        
        $march_start=$year_is.'-03-01';
        $march_end=$year_is.'-03-31';
        $array_query_months[2]=array('start_date'=>$march_start,'end_date'=>$march_end);
        
        
        $april_start=$year_is.'-04-01';
        $april_end=$year_is.'-04-30';
        $array_query_months[3]=array('start_date'=>$april_start,'end_date'=>$april_end);
        
        
        $may_start=$year_is.'-05-01';
        $may_end=$year_is.'-05-31';
        $array_query_months[4]=array('start_date'=>$may_start,'end_date'=>$may_end);
        
        
        $june_start=$year_is.'-06-01';
        $june_end=$year_is.'-06-30';
        $array_query_months[5]=array('start_date'=>$june_start,'end_date'=>$june_end);
        
        
        $july_start=$year_is.'-07-01';
        $july_end=$year_is.'-07-31';
        $array_query_months[6]=array('start_date'=>$july_start,'end_date'=>$july_end);
        
        
        $aug_start=$year_is.'-08-01';
        $aug_end=$year_is.'-08-31';
        $array_query_months[7]=array('start_date'=>$aug_start,'end_date'=>$aug_end);
        
        
        $sept_start=$year_is.'-09-01';
        $sept_end=$year_is.'-09-30';
        $array_query_months[8]=array('start_date'=>$sept_start,'end_date'=>$sept_end);
        
        
        $oct_start=$year_is.'-10-01';
        $oct_end=$year_is.'-10-31';
        $array_query_months[9]=array('start_date'=>$oct_start,'end_date'=>$oct_end);
        
        
        $nov_start=$year_is.'-11-01';
        $nov_end=$year_is.'-11-30';
        $array_query_months[10]=array('start_date'=>$nov_start,'end_date'=>$nov_end);
        
        
        $dec_start=$year_is.'-12-01';
        $dec_end=$year_is.'-12-31';
        $array_query_months[11]=array('start_date'=>$dec_start,'end_date'=>$dec_end);
        
        return $array_query_months;
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}


function return_script_order($passed_sort_column,$passed_sort_order,$required_column)
{
    $sort_order="asc";//by default its asc
    $passed_sort_column=trim(strtolower($passed_sort_column));
    $passed_sort_order=trim(strtolower($passed_sort_order));
    $required_column=trim(strtolower($required_column));
    
    if($passed_sort_column==$required_column)//if passed sort column is requested column make sort the opposite
    {
        $sort_order=$passed_sort_order=="asc"?"desc":"asc";
    }
    //else sort order is ascending
    
    return $sort_order;
}