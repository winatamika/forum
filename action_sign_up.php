<?php
error_reporting(0);
include "config/class_database.php";
include "config/serverconfig.php";

function randomcode($len="10") {
	$code = NULL;
	for($i=0;$i<$len;$i++) {
		$char = chr(rand(48,122));
		while(!ereg("[a-zA-Z0-9]", $char)) {
			if($char == $lchar) { continue; }
			$char = chr(rand(48,90));
		}
		$pass .= $char;
		$lchar = $char;
	}
	return $pass;
} // END randomcode() FUNCTION

$sql_sign_up = $db->database_prepare("SELECT * FROM as_member WHERE email = ?")->execute($_POST['email']);
$nums = $db->database_num_rows($sql_sign_up);

if ($_POST['password'] != $_POST['retype_password']){
	header("Location: sign-up.html?error=Error");
}
else{
	if ($nums > 0){
		header("Location: sign-up.html?error=Exist");
	}
	else{
		$password = md5($_POST['password']);
		$created_date = date('Y-m-d H:i:s');
		$verification = randomcode();
		
		$db->database_prepare("INSERT INTO as_member (	facebook_id,
														twitter_id,
														email,
														username,
														password,
														photo,
														first_name,
														last_name,
														province_id,
														city_id,
														cellphone,
														ym_id,
														address,
														biografi,
														status,
														created_date,
														modified_date,
														hits,
														verification_code)
												VALUES	(?,?,?,?,?,?,?,?,?,?,
														?,?,?,?,?,?,?,?,?)")
											->execute(	"",
														"",
														$_POST['email'],
														$_POST['username'],
														$password,
														"",
														"",
														"",
														0,
														0,
														"",
														"",
														"",
														"",
														"N",
														$created_date,
														"",
														0,
														$verification);
		
		$to = $_POST['email'];
		$pass = $_POST['password'];
		$username = $_POST['username'];
		$subject = "Asfasolution.com - Activation Code";
		$html = "<h5>Thank you for your registration at asfasolution.com</h5>
					<p>
					Your username : $username <br>
					Your email account : $to <br>
					Your password : $pass <br><br>
					
					Your activation code is $verification <br><br>
					For activation please click this url: <br>
					<a href='http://www.asfasolution.com/activate.php?code=$verification&email=$to'>http://www.asfasolution.com/activate.php?code=$verification&email=$to</a>
					<br><br><br>
					Thank You<br>
					This is an automated email. Do not reply. For trouble send to <a href='mailto: info@asfasolution.com'>info@asfasolution.com</a><br><br>
					Asfasolution.com
					</p>
					";
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'From: Membership-ASFA <membership@asfasolution.com>' . "\r\n";

		mail($to, $subject, $html, $headers);
		
		header("Location: success.html");
	}
}
?>