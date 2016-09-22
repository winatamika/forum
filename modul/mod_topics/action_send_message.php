<?php
error_reporting(0);
session_start();
include "../../config/class_database.php";
include "../../config/serverconfig.php";
require_once('../../config/recaptcha/recaptchalib.php');

if ($_SESSION['email_login'] != ''){
	
	$privatekey = "6LeAdO8SAAAAAOsNGH6VBrhqDu07QYmrxMSNuBrF";
	$resp = recaptcha_check_answer ($privatekey,
	$_SERVER["REMOTE_ADDR"],
	$_POST["recaptcha_challenge_field"],
	$_POST["recaptcha_response_field"]);
	$nm = md5(date('Ymdhis'));
	
	if (!$resp->is_valid){
		header("Location: ../../send-message-".$_POST['id']."-".$nm.".html?cp=no");
	}
	
	else{
		$created_date = date('Y-m-d H:i:s');
		$ref_id = $_SESSION["email_login"].$nm;
		$message = htmlspecialchars($_POST["description"]);
		
		$data = $db->database_fetch_array($db->database_prepare("SELECT email, username FROM as_member WHERE member_id = ?")->execute($_POST["id"]));
		
		$db->database_prepare("INSERT INTO as_frm_messages (	msgfrom,
																sendto,
																subject,
																message,
																status,
																created_date)
														VALUES	(?,?,?,?,?,?)")
													->execute(	$_SESSION["member_login"],
																$_POST["id"],
																$_POST["subject"],
																$message,
																0,
																$created_date);
		$insert = mysql_insert_id();
		
		$db->database_prepare("INSERT INTO as_frm_messages_sent(msgfrom, sendto, subject, message, created_date) VALUES(?,?,?,?,?)")
		->execute($_SESSION["member_login"],$_POST["id"],$_POST["subject"],$message,$created_date);
		
		$to = $_SESSION['email_login'];
		$title = $_POST['subject'];
		$username = $_SESSION['username'];
		$to_name = $data['email'];
		$to_user = $data['username'];
		$subject = "Asfasolution.com Forum - $title";
		$html = "	<p>
					Hi $to_user, <br><br>
					You've got the message at asfasolution.com forum.<br><br>
					Please Sign in to asfasolution.com forum to read the message.<br>
					<a href='http://www.asfasolution.com/sign-in.html?frm=yes'>http://www.asfasolution.com/sign-in.html?frm=yes</a>
					<br><br>
					Warm Regards,<br><br>
					Asfasolution.com
					</p>
					";
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'From: Asfasolution.com <noreply@asfasolution.com>' . "\r\n";
	
		mail($to_name, $subject, $html, $headers);
		header("Location: ../../send-message-".$_POST['id']."-".$nm.".html?save=ok?ref=".$ref_id);
	}
}
else{
	header("Location: ../../send-message-".$_POST['id']."-".$nm.".html?err=fail");
}
?>