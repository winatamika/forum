<script src="js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>

<script>
	function validateEmail(email) { 
		var re = /\S+@\S+\.\S+/
		return re.test(email);
	} 

	$(document).ready(function() {
		$('#frm_sign_in').validate({
			rules:{
				email: true,
				password: true
			},
			messages:{
				email:{
					required: "This is a required field."
				},
				password:{
					required: "This is a required field."
				}
			}
		});
	});
</script>

<p style='font-size: 18px; font-weight: bold;'>Sign In</p>
<table border="0" width="100%" bgcolor="#eae7e7" height="350">
	<tr>
		<td style="padding-left: 20px; padding-top: 50px;" width="45%" align="center" valign="top">
			It's Free, easy, and fast<br><br>
			<a href="#" onclick="connect_fb();"><img src="images/facebook.jpg"></a>
		</td>
		<td align="center" valign="top" style="padding-top: 120px;"><font color="#666">or</font> <br><div style="border-left: 1px solid rgba(0, 0, 0, 0.1); border-right: 1px solid rgba(255, 255, 255, 0.8); display: inline;"></div></td>
		<td valign="top" style="padding-left: 40px; padding-top: 80px;">
			<?php
			$full_url = full_url();
			if (strpos($full_url, "err=error_log") == TRUE){
				echo "<div class='messageerror'><p>We could not find a user matching your request.</p></div>";
			}
			?>
			<form method="POST" id="frm_sign_in" action="action_sign_in.php">
			<?php
			if (strpos($full_url, "?frm=yes") == TRUE){
				echo "<input type='hidden' name='iden' value='1'>";
			}
			?>
			<table>
				<tr>
					<td>
						<input type="text" id="email" class="required" placeholder="Your Email" name="email" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; height: 25px; width: 266px; margin-right: 10px; padding: 5px; margin-bottom: 10px;">
					</td>
				</tr>
				<tr>
					<td>
						<input type="password" id="password" class="required" placeholder="Your Password" name="password" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; height: 25px; width: 266px; margin-right: 10px; padding: 5px; margin-bottom: 10px;"><br>
					</td>
				</tr>
				<tr>
					<td><input type="submit" class="freeads" value="Sign In" id="buttonSignin"></td>
				</tr>
				<tr>
					<td><p>&nbsp;</p>
						<font color="#666">
							Forgot password? <a href="forget-password.html" class='black'>Click here</a>
						</font>
					</td>
				</tr>
			</table>
			</form>
			<br>
		</td>
	</tr>
</table>