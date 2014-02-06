$(document).ready(function() {  
  
        //the min chars for username  
        var min_chars = 3;  
  
        //result texts  
        var characters_error = 'Please enter a minimum of 3 characters to check';  
        var checking_html = 'Checking...';  
		
        //when button is clicked  
        $('#check_username_availability').click(function(){  
            //run the character number check
            if($('#username').val().length < min_chars){  
                //if it's bellow the minimum show characters_error text '  
                $('#username_availability_result').html(characters_error);
				
            }else{  
                //else show the cheking_text and run the function to check  
                $('#username_availability_result').html(checking_html);  
                check_availability();  
            }  
        });  
  
  });  
  
//function to check username availability  
function check_availability(){  
  
        //get the username  
        var username = $('#username').val();  
  
        //use ajax to run the check  
        $.post("unamecheck.php", { username: username },  
            function(result){  
                //if the result is 1  
                if(result == 1){  
                    //show that the username is available  
                    $('#username_availability_result').html( username + ' is Available');  
                }else{  
                    //show that the username is NOT available  
                    $('#username_availability_result').html(username + ' is not Available');  
                }  
        });  
  
}  
