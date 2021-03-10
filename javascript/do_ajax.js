


function search_for_me_please_city(url)
{
    var phrase=$("#phrase").val();
    
    if(phrase!=="")
    {
         $('#search_full_list').html("");
         $('#search_full_list').html("Searching...");
         
          data_is = {}
                    data_is["url"] = url;
                    data_is["data"] = "search_phrase="+phrase+"&sort_by=name&sort_order=ASC&limit=20&skip=0";
                    
        //alert(phrase);
         $.ajax({
                                        url: '../send_cross_domain/',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: JSON.stringify(data_is),
                                        cache: false,
                                        crossDomain: true,
                                        success: function(data) 
                                        { 
                                           
                                           // $('#search_full_list').html( (JSON.stringify(data)));
                                            var items = [];
                                            items=data;
                                            var check=items["check"];
                                             
                                            if(check===true)
                                            {
                                                var message=[];
                                                message=items["message"];
                                              $('#search_full_list').html(""); 
                                           
                                                $.each( message, function( key, val ) 
                                                {
                                                    var city_id= val['city_id'];
                                                    var region_id= val['region_id'];
                                                    var country_id= val['country_id'];
                                                    var city_latitude= val['city_latitude'];
                                                    var city_longitude= val['city_longitude'];
                                                    var city_name= val['city_name'];
                                                    var region_name= val['region_name'];
                                                    var region_code= val['region_code'];
                                                    var country_name= val['country_name'];
                                                    var country_code= val['country_code'];
                                                    
                                                     var write_this="<a href=\"#\" onclick=\"add_me_to_city_id('"+city_id+"','"+city_name+", "+region_name+" "+country_name+"')\" ><b>"+city_name+"</b>, "+region_name+" "+country_name+"</a>";
                                                            //$('#search_client_list').append("<li>"+write_this+" [<a href="+manage_invoices+">manage invoices</a>] [<a href="+all_invoices+">all invoices</a>] [<a href="+edit_info+">Edit</a>] [<a href="+delete_info+">Remove</a>]</li> "); 
                                                            $('#search_full_list').append("<li>"+write_this+"</li> "); 
                                                            
                                                    
                                                });
                                                       
                                            }


                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                          //alert(xhr.status);
                                          //alert(ajaxOptions);
                                        }
                                  });
    }
}

function add_me_to_city_id(city_id,city_name)
{
    $("#phrase").val(city_name);
    $("#use_me_city_id").val(city_id);
     $('#search_full_list').html(""); 
}


function search_for_me_please_disease(url)
{
    var phrase=$("#phrase").val();
    
    if(phrase!=="")
    {
         $('#search_full_list').html("");
         $('#search_full_list').html("Searching...");
         
          data_is = {}
                    data_is["url"] = url;
                    data_is["data"] = "search_phrase="+phrase+"&sort_by=short_description&sort_order=ASC&limit=20&skip=0";
                    
        //alert(phrase);
         $.ajax({
                                        url: '../send_cross_domain/',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: JSON.stringify(data_is),
                                        cache: false,
                                        crossDomain: true,
                                        success: function(data) 
                                        { 
                                           
                                           // $('#search_full_list').html( (JSON.stringify(data)));
                                            var items = [];
                                            items=data;
                                            var check=items["check"];
                                             
                                            if(check===true)
                                            {
                                                var message=[];
                                                message=items["message"];
                                              $('#search_full_list').html(""); 
                                           
                                                $.each( message, function( key, val ) 
                                                {
                                                    var diseases_id= val['_id'];
                                                    var disease_code= val['disease_code'];
                                                    var short_description= val['short_description'];
                                                    var long_description= val['long_description'];
                                                    
                                                     var write_this="<a href=\"#\" onclick=\"add_me_to_disease_id('"+diseases_id+"','"+short_description+" ["+disease_code+"]')\" ><b>"+short_description+"</b>  ["+disease_code+"]</a>";
                                                            //$('#search_client_list').append("<li>"+write_this+" [<a href="+manage_invoices+">manage invoices</a>] [<a href="+all_invoices+">all invoices</a>] [<a href="+edit_info+">Edit</a>] [<a href="+delete_info+">Remove</a>]</li> "); 
                                                            $('#search_full_list').append("<li>"+write_this+"</li> "); 
                                                            
                                                    
                                                });
                                                       
                                            }


                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                          //alert(xhr.status);
                                          //alert(ajaxOptions);
                                        }
                                  });
    }
}

function add_me_to_disease_id(diseases_id,short_description)
{
    $("#phrase").val(short_description);
    $("#use_me_diseases_id").val(diseases_id);
     $('#search_full_list').html(""); 
}

function search_for_me_please_people(url,exclude_id)
{
   
    var phrase=$("#phrase").val();
     
   
    if(phrase!=="") 
    {
         $('#search_full_list').html("");
         $('#search_full_list').html("Searching...");
         
          data_is = {}
                    data_is["url"] = url;
                    data_is["data"] = "search_phrase="+phrase+"&sort_by=name&sort_order=ASC&limit=20&skip=0";
                    
        //alert(phrase);
         $.ajax({
                                        url: '../send_cross_domain/',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: JSON.stringify(data_is),
                                        cache: false,
                                        crossDomain: true,
                                        success: function(data) 
                                        { 
                                           
                                           // $('#search_full_list').html( (JSON.stringify(data)));
                                            var items = [];
                                            items=data;
                                            var check=items["check"];
                                             
                                            if(check===true)
                                            {
                                                var message=[];
                                                message=items["message"];
                                              $('#search_full_list').html(""); 
                                           
                                                $.each( message, function( key, val ) 
                                                {
                                                    var _id= val['_id'];
                                                    var email_address= val['email_address'];
                                                    var name= val['name'];
                                                    
                                                    if(exclude_id!==_id)
                                                    {
                                                         var write_this="<a href=\"#\" onclick=\"add_me_to_person_id('"+_id+"','"+name+" ["+email_address+"]')\" ><b>"+name+"</b>  ["+email_address+"]</a>";
                                                            //$('#search_client_list').append("<li>"+write_this+" [<a href="+manage_invoices+">manage invoices</a>] [<a href="+all_invoices+">all invoices</a>] [<a href="+edit_info+">Edit</a>] [<a href="+delete_info+">Remove</a>]</li> "); 
                                                            $('#search_full_list').append("<li>"+write_this+"</li> "); 
                                                    }
                                                   
                                                    
                                                    
                                                            
                                                    
                                                });
                                                       
                                            }


                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                          //alert(xhr.status);
                                          //alert(ajaxOptions);
                                        }
                                  });
    }
}


function add_me_to_person_id(_id,name)
{
    $("#phrase").val(name);
    $("#user_id_to_id").val(_id);
     $('#search_full_list').html(""); 
}


var files_now_are=0;

function add_file_for_me()
{
    var file_name="add_file_for_me"+files_now_are;
    
    //alert(files_now_are);
    $('#files').append("<tr id=\""+file_name+"\"><td>"+(files_now_are+1)+"</th><th><input type=\"file\" required name=\"file["+files_now_are+"]\"></th><th><input type=\"button\" value=\"Remove\" onclick=\"remove_file_for_me('"+file_name+"')\"  ></th></tr>"); 
    
    files_now_are++;
}

function remove_file_for_me(file_name)
{
    $('#'+file_name).remove();
    
}


function search_for_me_please_user_type(url,exclude_id,type)
{
   
    var phrase=$("#phrase").val();
     
   
    if(phrase!=="") 
    {
         $('#search_full_list').html("");
         $('#search_full_list').html("Searching...");
         
          data_is = {}
                    data_is["url"] = url;
                    data_is["data"] = "search_phrase="+phrase+"&sort_by=name&sort_order=ASC&limit=20&skip=0&type="+type;
                    
        //alert(phrase);
         $.ajax({
                                        url: '../send_cross_domain/',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: JSON.stringify(data_is),
                                        cache: false,
                                        crossDomain: true,
                                        success: function(data) 
                                        { 
                                           
                                           // $('#search_full_list').html( (JSON.stringify(data)));
                                            var items = [];
                                            items=data;
                                            var check=items["check"];
                                             
                                            if(check===true)
                                            {
                                                enable_pickup_reset_personal();
                                                var message=[];
                                                message=items["message"];
                                              $('#search_full_list').html(""); 
                                           
                                                $.each( message, function( key, val ) 
                                                {
                                                    var _id= val['_id'];
                                                    var email_address= val['email_address'];
                                                    var name= val['name'];
                                                    
                                                    if(exclude_id!==_id)
                                                    {
                                                         var write_this="<a href=\"#\" onclick=\"add_me_to_person_id_type('"+_id+"','"+name+" ["+email_address+"]')\" ><b>"+name+"</b>  ["+email_address+"]</a>";
                                                            //$('#search_client_list').append("<li>"+write_this+" [<a href="+manage_invoices+">manage invoices</a>] [<a href="+all_invoices+">all invoices</a>] [<a href="+edit_info+">Edit</a>] [<a href="+delete_info+">Remove</a>]</li> "); 
                                                            $('#search_full_list').append("<li>"+write_this+"</li> "); 
                                                    }
                                                   
                                                    
                                                    
                                                            
                                                    
                                                });
                                                       
                                            }


                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                          //alert(xhr.status);
                                          //alert(ajaxOptions);
                                        }
                                  });
    }
}


function add_me_to_person_id_type(_id,name)
{
    $("#phrase").val(name);
    $("#user_id_to_id").val(_id);
     $('#search_full_list').html(""); 
}

function do_something_to_locations(enable_who,url)
{
    if(enable_who==="enable_personal")
    {
        //check if user id exists
        var user_id=$("#user_id_to_id").val();
        
        if(user_id!="")
        {
            $("#delivery_location_id_pickup").attr("disabled","true" );//disable pickup select
            $("#delivery_location_id_personal").removeAttr("disabled");//enable personal
            //alert(user_id); 
            //fetch locations
           $("#delivery_location_id_personal").html("");//clear
            $("#delivery_location_id_personal").html("<option value=\"\">Fetching addresses...</option>");
             
            data_is = {};
                    data_is["url"] = url;
                    data_is["data"] = "search_phrase=&sort_by=address_name&sort_order=ASC&limit=20&skip=0&user_id="+user_id+"&active=yes";
                    
      
                     $.ajax({
                                        url: '../send_cross_domain/',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: JSON.stringify(data_is),
                                        cache: false,
                                        crossDomain: true,
                                        success: function(data) 
                                        { 
                                           
                                           // $('#search_full_list').html( (JSON.stringify(data)));
                                            var items = [];
                                            items=data;
                                            var check=items["check"];
                                             
                                            if(check===true)
                                            {
                                                var message=[];
                                                message=items["message"];
                                                if(isEmpty(message)==false)
                                                {
                                                        $('#delivery_location_id_personal').html(""); 
                                           
                                                        //write the default first
                                                        $.each( message, function( key, val ) 
                                                        {
                                                            if(val["default"]=="yes")
                                                            {
                                                                $('#delivery_location_id_personal').html("<option value=\""+val["_id"]+"\" title=\""+val["available_location_comments"]+"\">[DEFAULT] "+val["address_name"]+": "+val["comments"]+" ("+val["city_name"]+", "+val["region_name"]+" "+val["country_name"]+")</option>"); 

                                                            }

                                                        });

                                                        $.each( message, function( key, val ) 
                                                        {
                                                            if(val["default"]!="yes")
                                                            {
                                                                $('#delivery_location_id_personal').append("<option value=\""+val["_id"]+"\" title=\""+val["available_location_comments"]+"\">"+val["address_name"]+": "+val["comments"]+" ("+val["city_name"]+", "+val["region_name"]+" "+val["country_name"]+")</option>"); 

                                                            }

                                                        });
                                                }
                                                else
                                                {
                                                      $("#delivery_location_id_personal").html("<option value=\"\">No available addresses</option>");
                                                }
                                                
                                                
                                                       
                                            }


                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                          //alert(xhr.status);
                                          //alert(ajaxOptions);
                                        }
                                  });
        }
        else
        {
            $("#location_is_pick_up_or_personal_pick_up").prop( "checked", true );//recheck pickup
            $("#location_is_pick_up_or_personal_personal").prop( "checked", false );//ucheck personal
            
            
            alert("Search and select a patient first!");
        }
    }
    else
    {
           
            enable_pickup_reset_personal();
    }
}

function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }

    return true;
}

function enable_pickup_reset_personal()
{
            $("#delivery_location_id_pickup").removeAttr("disabled");//enable pickup select
            $("#delivery_location_id_personal").attr("disabled","true");//disable personal
            
            $("#delivery_location_id_personal").html("");//clear
            $("#delivery_location_id_personal").html("<option value=\"\">Select personal location</option>");
            
            $("#location_is_pick_up_or_personal_pick_up").prop( "checked", true );//recheck pickup
            $("#location_is_pick_up_or_personal_personal").prop( "checked", false );//ucheck personal
}

function do_something_to_locations_no_fetch(enable_who)
{
    if(enable_who==="enable_personal")
    {
        //check if user id exists
        var user_id=$("#user_id_to_id").val();
        
        if(user_id!="")
        {
            $("#delivery_location_id_pickup").attr("disabled","true" );//disable pickup select
            $("#delivery_location_id_personal").removeAttr("disabled");//enable personal
            //alert(user_id); 
           
        }
        else
        {
            $("#location_is_pick_up_or_personal_pick_up").prop( "checked", true );//recheck pickup
            $("#location_is_pick_up_or_personal_personal").prop( "checked", false );//ucheck personal
            
            
          //  alert("Search and select a patient first!");
        }
    }
    else
    {
           
            enable_pickup_reset_personal();
    }
}


function search_for_me_medication(url)
{
    var phrase=$("#phrase_medication_id").val();
    
    if(phrase!=="")
    {
         $('#search_full_list_medication_id').html("");
         $('#search_full_list_medication_id').html("Searching...");
         
          data_is = {}
                    data_is["url"] = url;
                    data_is["data"] = "search_phrase="+phrase+"&sort_by=name&sort_order=ASC&limit=20&skip=0";
                    
        //alert(phrase);
         $.ajax({
                                        url: '../send_cross_domain/',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: JSON.stringify(data_is),
                                        cache: false,
                                        crossDomain: true,
                                        success: function(data) 
                                        { 
                                           
                                           // $('#search_full_list_medication_id').html( (JSON.stringify(data)));
                                            var items = [];
                                            items=data;
                                            var check=items["check"];
                                             
                                            if(check===true)
                                            {
                                                var message=[];
                                                message=items["message"];
                                              $('#search_full_list_medication_id').html(""); 
                                           
                                                $.each( message, function( key, val ) 
                                                {
                                                    var _id= val['_id'];
                                                    var name= val['name'];
                                                    var dosage_type= val['dosage_type'];
                                                    var dosage_form= val['dosage_form'];
                                                    var strength_type= val['strength_type'];
                                                    var strength_number= val['strength_number'];
                                                    var original_or_generic= val['original_or_generic'];
                                                    var chemical_name= val['chemical_name'];
                                                    var chemical_group_name= val['chemical_group_name'];
                                                    var treatment_name= val['treatment_name'];
                                                    var cost= val['cost'];
                                                    
                                                    

                                                    var name_to_use=name+" ["+strength_number+"."+strength_type+"]";
                                                     var title_use=treatment_name+">"+chemical_group_name+">>"+chemical_name;
                                                    var write_this="<a href=\"#\" onclick=\"add_me_to_medication_list('"+_id+"','"+name_to_use+"','"+cost+"')\" >"+name_to_use+"</a>";
                                                            //$('#search_client_list').append("<li>"+write_this+" [<a href="+manage_invoices+">manage invoices</a>] [<a href="+all_invoices+">all invoices</a>] [<a href="+edit_info+">Edit</a>] [<a href="+delete_info+">Remove</a>]</li> "); 
                                                            $('#search_full_list_medication_id').append("<li title=\""+title_use+"\">"+write_this+"</li> "); 
                                                            
                                                    
                                                });
                                                       
                                            }


                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                          //alert(xhr.status);
                                          //alert(ajaxOptions);
                                        }
                                  });
    }
}


function add_me_to_medication_list(_id,name,cost)
{
    $("#phrase_medication_id").val(name);
    $("#medication_id_use").val(_id);
     $('#search_full_list_medication_id').html(""); 
     
     try {
    $("#cost_per_sku_use").val(cost);
    } catch (e) {

    }
}


function search_for_me_diseases(url)
{
    var phrase=$("#disease_id_phrase").val();
    
    if(phrase!=="")
    {
         $('#search_full_list_active_disease_id').html("");
         $('#search_full_list_active_disease_id').html("Searching...");
         
          data_is = {}
                    data_is["url"] = url;
                    data_is["data"] = "search_phrase="+phrase+"&sort_by=short_description&sort_order=ASC&limit=20&skip=0&active=yes";
                    
        //alert(phrase);
         $.ajax({
                                        url: '../send_cross_domain/',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: JSON.stringify(data_is),
                                        cache: false,
                                        crossDomain: true,
                                        success: function(data) 
                                        { 
                                           
                                           // $('#search_full_list_active_disease_id').html( (JSON.stringify(data)));
                                            var items = [];
                                            items=data;
                                            var check=items["check"];
                                             
                                            if(check===true)
                                            {
                                                var message=[];
                                                message=items["message"];
                                              $('#search_full_list_active_disease_id').html(""); 
                                           
                                                $.each( message, function( key, val ) 
                                                {
                                                    var active_id= val['active_id'];
                                                    var disease_id= val['disease_id'];
                                                    var disease_code= val['disease_code'];
                                                    var short_description= val['short_description'];
                                                    var long_description= val['long_description'];
                                                    
                                                    

                                                    var name_to_use=short_description+" ["+disease_code+"]";
                                                     var title_use=long_description;
                                                    var write_this="<a href=\"#\" onclick=\"add_me_to_disease_list('"+active_id+"','"+name_to_use+"')\" >"+name_to_use+"</a>";
                                                            //$('#search_client_list').append("<li>"+write_this+" [<a href="+manage_invoices+">manage invoices</a>] [<a href="+all_invoices+">all invoices</a>] [<a href="+edit_info+">Edit</a>] [<a href="+delete_info+">Remove</a>]</li> "); 
                                                            $('#search_full_list_active_disease_id').append("<li title=\""+title_use+"\">"+write_this+"</li> "); 
                                                            
                                                    
                                                });
                                                       
                                            }


                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                          //alert(xhr.status);
                                          //alert(ajaxOptions);
                                        }
                                  });
    }
}

function add_me_to_disease_list(_id,name)
{
    //alert(_id);
    $("#disease_id_phrase").val(name);
    $("#active_disease_id_use").val(_id);
     $('#search_full_list_active_disease_id').html(""); 
     
    
}