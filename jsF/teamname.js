$(document).ready(function() {  
  
        //the min chars for teamname  
        var min_chars = 3;  
  
        //result texts  
        var characters_error = 'Please enter a minimum of 3 characters to check';  
        var checking_html = 'Checking...';  
		
        //when button is clicked  
        $('#check_teamname_availability').click(function(){  
            //run the character number check
            if($('#team_name').val().length < min_chars){  
                //if it's bellow the minimum show characters_error text '  
                $('#teamname_availability_result').html(characters_error);
				
            }else{  
                //else show the cheking_text and run the function to check  
                $('#teamname_availability_result').html(checking_html);  
                check_team_name_availability();  
            }  
        });  
  
  });  
  
//function to check teamname availability  
function check_team_name_availability(){  
  
        //get the teamname  
        var team_name = $('#team_name').val();  
  
        //use ajax to run the check  
        $.post("tnamecheck.php", { team_name: team_name },  
            function(result){  
                //if the result is 1  
                if(result == 1){  
                    //show that the teamname is available  
                    $('#teamname_availability_result').html( team_name + ' is Available');  
                }else{  
                    //show that the teamname is NOT available  
                    $('#teamname_availability_result').html(team_name + ' is not Available');  
                }  
        });  
  
}  
