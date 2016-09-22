<link rel="stylesheet" type="text/css" media="all" href="../js/fancybox/jquery.fancybox.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="../js/fancybox/jquery.fancybox.js?v=2.0.6"></script>
<script type="text/javascript" src="../js/chat.js"></script>
<link rel="stylesheet" href="../css/jquery-tab.css" type="text/css" />
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="../js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="../js/ckeditor/ckeditor.js"></script>

<script>
jQuery(document).ready(function(){
	$('#contact').validate({
		rules:{
			msg: true
		},
		messages:{
			msg:{
				required: "This is a required field."
			}
		}
	});
	
	/*$(".modalbox").fancybox();
	$( "#tabs" ).tabs();
	$("#contact").submit(function() { return false; });
	
	$("#send").on("click", function(){
		var msg		= $("#msg").val();
		var old_msg = $("#old_msg").val();
		var memberid= $("#member_id").val();
		var msgid	= $("#msgid").val();
		var subject	= $("#subject").val();
		var msglen	= msg.length;
		
		$("#send").replaceWith("<em>Sending...</em>");
			
		$.ajax({
			type: 'POST',
			url: 'modul/mod_messages/send_message.php',
			data: $("#contact").serialize(),
			success: function(data) {
				if(data == "true") {
					$("#contact").fadeOut("fast", function(){
						$(this).before("<p><strong>Success! Your message has been sent.</strong></p>");
						setTimeout("$.fancybox.close()", 1000);
						top.location.href = 'http://www.oaseast.com/forum/read-messages-1-'+msgid+'.html?succ=sent';
					});
				}
			}
		});
	});*/
});
</script>

<div class="main-column-wrapper2">
	<div class="main-column-left2">
		<div class="post-title2">
			<b>MESSAGES</b>
		</div>
		<?php
		$nm = md5(date('Ymdhis'));
		$full_url = full_url();
		if (strpos($full_url, "?succ=ok") == TRUE){
			echo "<div class='messagesuccess' style='width: auto;'><p><b>Your message has been sent.</b></p></div>";
		}
		
		if (strpos($full_url, "?succ=sent") == TRUE){
			echo "<div class='messagesuccess' style='width: auto;'><p><b>Your message has been sent.</b></p></div>";
		}
		$db->database_prepare("UPDATE as_frm_messages SET status = 1 WHERE message_id = ?")->execute($_GET["id"]);
		$num_messages_inbox = $db->database_num_rows($db->database_prepare("SELECT * FROM as_frm_messages WHERE sendto = ? AND status = 0")->execute($_SESSION["member_login"]));
		$num_messages_inbox_all = $db->database_num_rows($db->database_prepare("SELECT * FROM as_frm_messages WHERE sendto = ?")->execute($_SESSION["member_login"]));
		$num_messages_sentitem = $db->database_num_rows($db->database_prepare("SELECT * FROM as_frm_messages_sent WHERE msgfrom = ?")->execute($_SESSION["member_login"]));
		?>

		<div id="rotator2">  
			
			<ul class="ui-tabs-nav">  
			    <li <?php if ($_GET['div'] == 1){ echo "class='ui-tabs-selected1'"; } else { echo "class='ui-tabs-nav-item1'"; } ?>><a href="messages-1-1.html" class='black'><span>Inbox (<?php if ($num_messages_inbox > 0){ echo "<b>$num_messages_inbox</b>"; } else{ echo "0"; } ?> of <?php echo $num_messages_inbox_all; ?>)</span></a></li>  
			    <li <?php if ($_GET['div'] == 2){ echo "class='ui-tabs-selected2'"; } else { echo "class='ui-tabs-nav-item2'"; } ?>><a href="messages-2-1.html" class='black'><span>Sentitems (<?php if($num_messages_sentitem > 0){ echo "$num_messages_sentitem"; } else{ echo "0"; } ?>)</span></a></li>
			</ul>
			
			<div id="fragment-1" class="ui-tabs-panel">
			<table>
				<tr>
					<td><a href='messages-<?php echo $_GET['div']; ?>-1.html' class='black'><img src='images/back.jpg' width='30'></a></td>
					<td><a href='messages-<?php echo $_GET['div']; ?>-1.html' class='black'>Back to Messages</a></td>
				</tr>
			</table>
			<?php
			if ($_GET['div'] == 1){
				$data_messages = $db->database_fetch_array($db->database_prepare("SELECT B.username, A.created_date, B.member_id, A.message, B.photo, A.subject, A.message_id
																		FROM as_frm_messages A INNER JOIN as_member B ON B.member_id = A.msgfrom
																		WHERE A.message_id = ? AND sendto = ?")->execute($_GET["id"],$_SESSION["member_login"]));
				if ($data_messages['photo'] != ''){
					$photo = "<img src='images/photo_member/thumb/small_$data_messages[photo]' width='60' height='70' style='border-radius: 8px; border: 2px solid #CCCCCC;'>";
				}
				else{
					$photo = "<img src='images/no_photo.jpg' width='60' height='70' style='border-radius: 8px; border: 2px solid #CCCCCC;'>";
				}
			?>    <br>
			    <table border="0" width="100%" class="tr" cellspacing="0">
			    	<tr>
			    		<td width='70' rowspan="4"><?php echo $photo; ?></td>
			    		<td width='60'>Date</td>
			    		<td width='10'>:</td>
			    		<td><b><?php echo $data_messages['created_date']; ?></b></td>
			    	</tr>
			    	<tr>
			    		<td>From</td>
			    		<td>:</td>
			    		<td><b><a href='profile-<?php echo $data_messages['member_id']; ?>-<?php echo $nm; ?>.html' class='black'><?php echo $data_messages['username']; ?></a></b></td>
			    	</tr>
			    	<tr>
			    		<td>Subject</td>
			    		<td>:</td>
			    		<td><b><?php echo $data_messages['subject']; ?></b></td>
			    	</tr>
				</table><br>
				<b>Message:</b><br>
				<?php echo htmlspecialchars_decode($data_messages['message']); ?>
				<p style="font-size:12pt; font-weight: bold;">Reply Message:</p>
				<form id='contact' name='contact' action='modul/mod_messages/send_message.php' method='post'>
		    	<input type="hidden" id="msgid" name="msgid" value="<?php echo $data_messages['message_id']; ?>">
		    	<input type='hidden' id='member_id' name='member_id' value='<?php echo $data_messages['member_id']; ?>'>
		    	<input type='hidden' id='subject' name='subject' value='<?php echo $data_messages['subject']; ?>'>
				<input type='hidden' id='old_msg' name='old_msg' value="<?php echo htmlspecialchars_decode($data_messages['message']); ?>">
   				<textarea id='msg' name='msg' cols='40'></textarea><br>
   				<button id='send' type="submit">Send Message</button>
				<br>
			<?php
			}
			else{
				$data_messages = $db->database_fetch_array($db->database_prepare("SELECT B.username, A.created_date, B.member_id, A.subject, A.message, B.photo, A.message_id
																		FROM as_frm_messages_sent A INNER JOIN as_member B ON B.member_id = A.sendto
																		WHERE A.message_id = ? AND msgfrom = ?")->execute($_GET["id"],$_SESSION["member_login"]));
				if ($data_messages['photo'] != ''){
					$photo = "<img src='images/photo_member/thumb/small_$data_messages[photo]' width='60' height='70' style='border-radius: 8px; border: 2px solid #CCCCCC;'>";
				}
				else{
					$photo = "<img src='images/no_photo.jpg' width='60' height='70' style='border-radius: 8px; border: 2px solid #CCCCCC;'>";
				}
			?><br>
				<table border="0" width="100%" class="tr" cellspacing="0">
			    	<tr>
			    		<td width='70' rowspan="4"><?php echo $photo; ?></td>
			    		<td width='60'>Date</td>
			    		<td width='10'>:</td>
			    		<td><b><?php echo $data_messages['created_date']; ?></b></td>
			    	</tr>
			    	<tr>
			    		<td>To</td>
			    		<td>:</td>
			    		<td><b><a href='profile-<?php echo $data_messages['member_id']; ?>-<?php echo $nm; ?>.html' class='black'><?php echo $data_messages['username']; ?></a></b></td>
			    	</tr>
			    	<tr>
			    		<td>Subject</td>
			    		<td>:</td>
			    		<td><b><?php echo $data_messages['subject']; ?></b></td>
			    	</tr>
				</table><br>
				<b>Message:</b><br>
				<?php 
				echo htmlspecialchars_decode($data_messages['message']);	
			}
			?>
			</div>
		</div><!-- end rotator -->
	</div>
</div>
<script>
	CKEDITOR.replace( 'msg' );
</script>