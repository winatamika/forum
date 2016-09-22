<script src="js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="js/ajaxupload.3.5.js"></script>
<link rel="stylesheet" type="text/css" href="css/Ajaxfile-upload.css" />

<script>
	var htmlobjek;
	function validateEmail(email) { 
		var re = /\S+@\S+\.\S+/
		return re.test(email);
	}
	
	function Count(){
		var karakter,maksimum;  
		maksimum = 500
		karakter = maksimum-(document.frm_profile.biografi.value.length);  
		if (karakter < 0) {
			alert("Max. characters:  " + maksimum + "");  
			document.frm_profile.biografi.value = document.frm_profile.biografi.value.substring(0,maksimum);  
			karakter = maksimum-(document.frm_profile.biografi.value.length);  
			document.frm_profile.counter.value = karakter;  
		} 
		else {
			document.frm_profile.counter.value =  maksimum-(document.frm_profile.biografi.value.length);
		}
	} 

	jQuery(document).ready(function(){
		$("#province").change(function(){
			var province = $("#province").val();
			$.ajax({
				url: "get_city.php",
				data: "province="+province,
				cache: false,
				success: function(msg){
					$("#city").html(msg);
				}
			});
		});
		
		$('#frm_profile').validate({
			rules:{
				username: true,
				first_name: true,
				province: true,
				city: true,
				address: true
			},
			messages:{
				username:{
					required: "This is a required field."
				},
				first_name:{
					required: "This is a required field."
				},
				province:{
					required: "This is a required field."
				},
				city:{
					required: "This is a required field."
				},
				address:{
					required: "This is a required field."
				}
			}
		});
		
		$("#username").change(function()
		{ //if theres a change in the username textbox
			var username = $("#username").val();//Get the value in the username textbox
			$("#availability_username").html('<img src="images/loader.gif" align="absmiddle">&nbsp;Checking availability...');
			//Add a loading image in the span id="availability_status"
			$.ajax({  //Make the Ajax Request
				type: "POST",
				url: "modul/mod_sign_up/check_username.php",  //file name
				data: "username="+ username,  //data
				success: function(server_response){
					$("#availability_username").ajaxComplete(function(event, request){
						if(server_response == '0')//if ajax_check_username.php return value "0"
						{
							$("#availability_username").html('<div class="available"> Username is Available </div>  ');
							document.getElementById("button_profile").disabled = false;
							//add this image to the span with id "availability_status"
						}
						else  if(server_response == '1')//if it returns "1"
						{
							$("#availability_username").html('<div class="error">Username is already used</div>');
							document.getElementById("button_profile").disabled = true; 
						}
						else  if(server_response == '2')//if it returns "1"
						{
							$("#availability_username").html('<div class="error">Username can only contain letters and numbers</div>');
							document.getElementById("button_profile").disabled = true; 
						}
					});
				}
			});
		});
		
		var btnUpload=$('#me');
		var mestatus=$('#mestatus');
		var files=$('#files');
		new AjaxUpload(btnUpload, {
			action: 'modul/mod_profile/upload_profile.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|jpeg)$/.test(ext))){ 
                    // extension is not allowed 
					mestatus.text('Only JPG file are allowed');
					return false;
				}
				mestatus.html('<img src="images/loader.gif" height="16" width="16">');
			},
			onComplete: function(file, response){
				//On completion clear the status
				mestatus.text('');
				//On completion clear the status
				files.html('');
				//Add uploaded file to list
				if(response!=="error"){
					$('<li></li>').appendTo('#files').html('<img src="images/photo_member/'+response+'" alt="" width="100" style="border-radius: 10px; border: 3px solid #ccc"/><br />').addClass('success');
					$('<li></li>').appendTo('#member').html('<input type="hidden" name="filename" value="'+response+'">').addClass('nameupload');
					
				} else{
					$('<li></li>').appendTo('#files').text(file).addClass('error');
				}
			}
		});
	});
</script>

<?php
$data_profile = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_member A WHERE A.email = ?")->execute($_SESSION['email_login']));
?>
<div class='main-column-wrapper'>
	<div class='main-column-left2'>
		<div class='blog-style-2'>
			<p style="font-size:18px; font-weight: bold;">Edit Profile</p>
			<form method="POST" id="frm_profile" name="frm_profile" action="modul/mod_profile/action_update_profile.php">
			<table width="100%">
				<tr valign="top">
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;" width="130"><b>Upload Photo</b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<div id="me" style="cursor:pointer; height: 40px; width: 72px;">
							<label>
								<button class="button_profile">Browse</button>
							</label>
						</div>
						<span id="mestatus" ></span>
						<div id="member">
							<li class="nameupload"></li>
						</div>
						<div id="files">
							<li class="success">
								<?php 
								if ($data_profile['photo'] != ''){
									echo "<img src='images/photo_member/thumb/small_$data_profile[photo]' width='100' style='border: 3px solid #ccc; border-radius: 10px;'>";
								} 
								?>
			              </li>
			            </div>
					</td>
				</tr>
				<!--<?php if ($data_profile['username'] != ''){
				?>-->
					<tr valign="top">
						<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"><b>Username</b></td>
						<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
							<!--<input type="text" id="username" class="required" value="<?php echo $data_profile['username']; ?>" placeholder="Username, Only Contain Letters and Numbers" name="username" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; height: 20px; width: 266px; margin-right: 10px; padding: 5px;" DISABLED>
							<span id="availability_username"></span>-->
							<?php echo $data_profile['username']; ?>
						</td>
					</tr>
				<!--<?php
				}
				else{
				?>
				
					<tr valign="top">
						<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"><b>Username</b></td>
						<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
							<input type="text" id="username" class="required" placeholder="Username, Only Contain Letters and Numbers" name="username" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; height: 20px; width: 266px; margin-right: 10px; padding: 5px;">
							<span id="availability_username"></span>
						</td>
					</tr>
				<?php
				}
				?>-->
				<tr>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"><b>Email</b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<input type="text" id="email" placeholder="Your Email" value="<?php echo $data_profile['email']; ?>" name="email" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; height: 20px; width: 266px; margin-right: 10px; padding: 5px;" DISABLED>
					</td>
				</tr>
				<tr>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"><b>First Name</b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<input type="text" id="first_name" class="required" placeholder="First Name" value="<?php echo $data_profile['first_name']; ?>" name="first_name" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; height: 20px; width: 266px; margin-right: 10px; padding: 5px;">
					</td>
				</tr>
				<tr>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"><b>Last Name</b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<input type="text" id="last_name" placeholder="Last Name" value="<?php echo $data_profile['last_name']; ?>" name="last_name" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; height: 20px; width: 266px; margin-right: 10px; padding: 5px;">
					</td>
				</tr>
				<tr>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"><b>Phone/Cellphone</b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<input type="text" id="cellphone" placeholder="Phone or Cellphone" value="<?php echo $data_profile['cellphone']; ?>" name="cellphone" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; height: 20px; width: 266px; margin-right: 10px; padding: 5px;">
					</td>
				</tr>
				<tr>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"><b>Hide Phone</b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<input type="checkbox" id="hide_phone" placeholder="Phone or Cellphone" value="1" name="hide_phone" <?php if ($data_profile['hidden_cellphone'] == 1){ echo "CHECKED"; } ?>>
					</td>
				</tr>
				<tr>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"><b>Yahoo Messenger ID</b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<input type="text" id="ym_id" placeholder="Yahoo Messenger ID" value="<?php echo $data_profile['ym_id']; ?>" name="ym_id" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; height: 20px; width: 266px; margin-right: 10px; padding: 5px;">
					</td>
				</tr>
				<tr valign="top">
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"><b>Address</b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<textarea rows="3" id="address" class="required" placeholder="Address" name="address" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; width: 266px; margin-right: 10px; padding: 5px;"><?php echo $data_profile['address']; ?></textarea>
					</td>
				</tr>
				<tr>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"><b>Province</b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<select name="province" id="province" class="required" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; width: 266px; margin-right: 10px; padding: 5px;">
							<?php 
							$sql_province = $db->database_prepare("SELECT * FROM as_provinces WHERE status = 'Y' ORDER BY province_name ASC")->execute();
							while ($data_province = $db->database_fetch_array($sql_province)){
								if ($data_province['province_id'] == $data_profile['province_id']){
									echo "<option value='$data_province[province_id]' SELECTED>$data_province[province_name]</option>";
								}
								else{
									echo "<option value='$data_province[province_id]'>$data_province[province_name]</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"><b>City</b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<select name="city" id="city" class="required" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; width: 266px; margin-right: 10px; padding: 5px;">
							<?php 
							if ($data_profile['city_id'] != ''){
								$sql_city = $db->database_prepare("SELECT * FROM as_cities WHERE status = 'Y' AND province_id = ? ORDER BY city_name ASC")->execute($data_profile['province_id']);
								while ($data_city = $db->database_fetch_array($sql_city)){
									if ($data_city['city_id'] == $data_profile['city_id']){
										echo "<option value='$data_city[city_id]' SELECTED>$data_city[city_name]</option>";
									}
									else{
										echo "<option value='$data_city[city_id]'>$data_city[city_name]</option>";
									}
								}
							}
							else{
								echo "<option value=''></option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"><b>Biography</b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<textarea rows="6" id="biografi" placeholder="Biography" name="biografi" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; width: 500px; margin-right: 10px; padding: 5px;"
						OnFocus="Count();" OnClick="Count();" onKeydown="Count();" OnChange="Count();" onKeyup="Count();"><?php echo $data_profile['biografi']; ?></textarea>
						<br>
						<input name="counter" id="counter" type="text" size="5" value="500" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; width: 40px; margin-left: 410px; margin-top: 5px; padding: 5px;"> <b>Remain</b>
					</td>
				</tr>
				<tr valign="top">
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<input type="submit" class="button_profile" value="SAVE" id="button_profile">
					</td>
				</tr>
			</table>
			</form>
			<p>&nbsp;</p>
		</div>
	</div>
</div>