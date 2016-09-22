<script src="../js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>

<script>
	jQuery(document).ready(function(){
		$('#frm_user').validate({
			rules:{
				username: true
			},
			messages:{
				username:{
					required: "This is a required field."
				}
			}
		});
		
		$("#username").change(function()
		{ //if theres a change in the username textbox
			var username = $("#username").val();//Get the value in the username textbox
			$("#availability_username").html('<img src="../images/loader.gif" align="absmiddle">&nbsp;Checking availability...');
			//Add a loading image in the span id="availability_status"
			$.ajax({  //Make the Ajax Request
				type: "POST",
				url: "../modul/mod_sign_up/check_username.php",  //file name
				data: "username="+ username,  //data
				success: function(server_response){
					$("#availability_username").ajaxComplete(function(event, request){
						if(server_response == '0')//if ajax_check_username.php return value "0"
						{
							$("#availability_username").html('<div class="user_available"> Username is Available </div>  ');
							document.getElementById("buttonSignup").disabled = false;
							//add this image to the span with id "availability_status"
						}
						else  if(server_response == '1')//if it returns "1"
						{
							$("#availability_username").html('<div class="user_error">Username is already used</div>');
							document.getElementById("buttonSignup").disabled = true; 
						}
						else  if(server_response == '2')//if it returns "1"
						{
							$("#availability_username").html('<div class="user_error">Username can only contain letters and numbers</div>');
							document.getElementById("buttonSignup").disabled = true; 
						}
					});
				}
			});
		});
	});
</script>

<p style='font-size: 18px; font-weight: bold;'>Set Your Username</p>
<?php
$full_url = full_url();
if (strpos($full_url, "?err=fail") == TRUE){
	echo "<div class='messageerror' style='width: auto;'><p><b>Your profile is failed updated, username is already used.</b></p></div>";
}

if (strpos($full_url, "?err=noesc") == TRUE){
	echo "<div class='messageerror' style='width: auto;'><p><b>Set Username is failed, Username only contain letters and numbers.</b></p></div>";
}
?>
<table border="0" width="100%" bgcolor="#eae7e7">
	<tr>
		<td valign="middle" style="padding-left: 40px; padding-top: 50px;">
			<form method="POST" id="frm_user" action="action_username.php">
			<table>
				<tr>
					<td>
						<input type="text" id="username" class="required" placeholder="Username, Only Contain Letters and Numbers" name="username" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; height: 25px; width: 300px; margin-right: 10px; padding: 5px; margin-bottom: 10px;">
						<span id="availability_username"></span>
					</td>
				</tr>
				<tr>
					<td><input type="image" class="simplebtn" id="buttonSignup" src='../images/save.png'></td>
				</tr>
			</table>
			</form>
			<br>
		</td>
	</tr>
</table>