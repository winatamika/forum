<?php
if ($_SESSION['email_login'] != '' && $_SESSION['username'] == ''){
	include "update_username.php";
}

else{
	
	if ($_GET['module'] == 'home'){
		include "modul/mod_home/home.php";
	}
	
	elseif ($_GET['module'] == 'add-new-post'){
		include "modul/mod_topics/add_new_topic.php";
	}
	
	elseif ($_GET['module'] == 'topic'){
		include "modul/mod_topics/topic.php";
	}
	
	elseif ($_GET['module'] == 'detail-post'){
		include "modul/mod_topics/detail_topic.php";
	}
	
	elseif ($_GET['module'] == 'cat_detail'){
		include "modul/mod_topics/cat_detail.php";
	}
	
	elseif ($_GET['module'] == 'all-categories'){
		include "modul/mod_categories/all_categories.php";
	}
	
	elseif ($_GET['module'] == 'sign_in'){
		include "modul/mod_sign_in/sign_in.php";
	}
	
	elseif ($_GET['module'] == 'sign_up'){
		include "modul/mod_sign_up/sign_up.php";
	}
	
	elseif ($_GET['module'] == 'profile'){
		include "modul/mod_profile/profile.php";
	}
	
	elseif ($_GET['module'] == 'edit_profile'){
		include "modul/mod_profile/edit_profile.php";
	}
	
	elseif ($_GET['module'] == 'profile_member'){
		include "modul/mod_profile/profile_member.php";
	}
	
	elseif ($_GET['module'] == 'messages'){
		include "modul/mod_messages/messages.php";
	}
	
	elseif ($_GET['module'] == 'send_message'){
		include "modul/mod_topics/send_message.php";
	}
	
	// READ MESSAGES
	elseif ($_GET['module']=='read-messages'){
		if ($_SESSION['email_login'] != ''){
			include "modul/mod_messages/read_messages.php";
		}
		else{
			header("Location: sign-in.html?err=log");
		}
	}
	
	// SUCCESS
	elseif ($_GET['module']=='success'){
		echo "
			<div class='main-column-wrapper'>
				<div class='main-column-left2'>
					<div class='blog-style-2'>
						<div class='post-title2'>
							<b>Please Check Your Email!</b>
						</div>
						<p style='height: 300px;'>Thank you for your registration Your account not yet activated.<br>
						We send you an activation email to your email. Please read the instruction to activate immediately.</p>
					</div>
				</div>
			</div>
		";
	}
	
	elseif ($_GET['module'] == 'sign_out'){
		session_destroy();
		
		header("Location: home");
	}
}
?>