<script type="text/javascript" src="js/ajaxupload.3.5.js"></script>
<link rel="stylesheet" type="text/css" href="css/Ajaxfile-upload.css"; ?>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>

<script>
	jQuery(document).ready(function(){
		$('#frm_topic').validate({
			rules:{
				title: true,
				category: true
			},
			messages:{
				title:{
					required: "This is a required field."
				},
				category:{
					required: "This is a required field."
				}
			}
		});
		
		var btnUpload=$('#me');
		var mestatus=$('#mestatus');
		var files=$('#files');
		new AjaxUpload(btnUpload, {
			action: 'modul/mod_topics/upload_image.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|jpeg)$/.test(ext))){ 
                    // extension is not allowed 
					mestatus.text('Only JPG file are allowed');
					return false;
				}
				mestatus.html('<img src="ajax-loader.gif" height="16" width="16">');
			},
			onComplete: function(file, response){
				//On completion clear the status
				mestatus.text('');
				//On completion clear the status
				files.html('');
				//Add uploaded file to list
				if(response!=="error"){
					$('<li></li>').appendTo('#files').html('<img src="images/photo_topics/'+response+'" alt="" width="70" height="70" style="border-radius: 10px; margin-left: -3px; margin-top:-80px; border: 3px solid #ccc"/><br />').addClass('success');
					$('<li></li>').appendTo('#topic').html('<input type="hidden" name="filename" value="'+response+'">').addClass('nameupload');
					
				} else{
					$('<li></li>').appendTo('#files').text(file).addClass('error');
				}
			}
		});
	});
</script>

<div class='main-column-wrapper'>
	<div class='main-column-left2'>
		<div class='blog-style-2'>
			<?php
			$full_url = full_url();
			if (strpos($full_url, "?cp=no") == TRUE){
				echo "<div class='messageerror' style='width: auto;'><p><b>Captcha is Wrong.</b></p></div>";
			}
			?>
			<div class='post-title2'>
				<p style="font-size: 18px; font-weight: bold;">Add Topic</p>
			</div>
			<form method="POST" id="frm_topic" action="modul/mod_topics/action_add_topic.php" name="frm_topic">
			<table width="100%">
				<tr>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;" width="130"><b>Title <font color="#CC0000">*</font></b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<input type="text" class="required" maxlength="120" id="title" placeholder="Title, Max. 120 characters" name="title" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; height: 20px; width: 266px; margin-right: 10px; padding: 5px;">
						Max. 120 Characters
					</td>
				</tr>
				<tr>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"><b>Category <font color="#CC0000">*</font></b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<select name="category" class="required" id="category" style="background: #FFF; border: 1px solid #DDD; border-radius: 5px; box-shadow: 0 0 5px #DDD inset; color:#666; outline: none; width: 266px; margin-right: 10px; padding: 5px;">
							<option value="">- Select Category -</option>
							<?php
							$sql_category = $db->database_prepare("SELECT * FROM as_frm_categories WHERE status = 'Y' ORDER BY category_name ASC")->execute();
							while ($data_category = $db->database_fetch_array($sql_category)){
								
								$sql = $db->database_prepare("SELECT * FROM as_frm_sub_categories WHERE status = 'Y' AND frm_category_id = ? ORDER BY category_name ASC")->execute($data_category['frm_category_id']);
								while ($data = $db->database_fetch_array($sql))
								{
									echo "<option value='$data_category[frm_category_id]-$data[frm_sub_category_id]'>$data_category[category_name] - $data[category_name]</option>";
								}
								
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"><b>Post</b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						<textarea rows="10" id="description" placeholder="Description" name="description"></textarea>
					</td>
				</tr>
				<tr valign="top">
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;" width="130"><b>Upload Image</b></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;">
						
						<div id="me" style="cursor:pointer; height: 70px; width: 75px;">
							<button class="button_profile"><img src="images/add.png" width="50"></button>
								
							<div id="topic">
								<li class="nameupload"></li>
							</div>
							<div id="files">
								<li class="success"></li>
					        </div>
						</div>
						<span id="mestatus" ></span>						
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<?php
						require_once('config/recaptcha/recaptchalib.php');
						$publickey = "6LeAdO8SAAAAAEuxDK-Lf6QagL_NaJWWeKBZovU0";
						echo recaptcha_get_html($publickey);
						?>
					</td>
				</tr>
				<tr valign="top">
					<td style="padding-bottom: 5px; padding-top: 5px; padding-left: 5px;"></td>
					<td style="padding-bottom: 5px; padding-top: 5px; padding-right: 5px;"><br>
						<input type="submit" class="button_profile" value="SAVE">
					</td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>
<script>
	CKEDITOR.replace( 'description' );
</script>