<?php
error_reporting(0);
session_start();
include "../../config/class_database.php";
include "../../config/serverconfig.php";

$member_id = $_POST['member_id'];
$message = htmlspecialchars($_POST['msg']);
$msgfrom = $_SESSION['member_login'];
$email_login = $_SESSION['email_login'];

$data = $db->database_fetch_array($db->database_prepare("SELECT A.email, A.first_name, A.last_name, A.username FROM as_member A WHERE A.member_id = ?")->execute($member_id));

$subject = "$_POST[subject] from asfasolution.com";
$send_to = $data_member['email'];
$created_date = date('Y-m-d H:i:s');


$save = $db->database_prepare("INSERT INTO as_frm_messages (msgfrom, sendto, subject, message, status, created_date) VALUES(?,?,?,?,?,?)")
	->execute($msgfrom,$member_id,$_POST["subject"],$message,0,$created_date);
	
if ($save){
	$db->database_prepare("INSERT INTO as_frm_messages_sent(msgfrom, sendto, subject, message, created_date) VALUES(?,?,?,?,?)")
	->execute($msgfrom,$member_id,$_POST["subject"],$message,$created_date);
	$msgid = mysql_insert_id();
	
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
	
//	echo "true";
	header("Location: ../../read-messages-2-".$msgid.".html");
}
else{
	//echo "false";
	header("Location: ../../read-messages-1-".$_POST['msg_id'].".html");
}
?>