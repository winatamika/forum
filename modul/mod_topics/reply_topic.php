<?php
error_reporting(0);
session_start();
include "../../config/class_database.php";
include "../../config/serverconfig.php";
include "../../config/debug.php";
include "../../config/fungsi_seo.php";
require_once('../../config/recaptcha/recaptchalib.php');

if ($_SESSION['email_login'] != ''){
	
	$privatekey = "6LeAdO8SAAAAAOsNGH6VBrhqDu07QYmrxMSNuBrF";
	$resp = recaptcha_check_answer ($privatekey,
	$_SERVER["REMOTE_ADDR"],
	$_POST["recaptcha_challenge_field"],
	$_POST["recaptcha_response_field"]);
	
	
	if (!$resp->is_valid){
		header("Location: ../../detail-".$_POST['topic_id']."-".$_POST['title_seo'].".html?cp=no");
	}
	
	else{
		$created_date = date('Y-m-d H:i:s');
		$comment = htmlspecialchars($_POST["description"]);
		$infosave = md5($created_date);
		
		$db->database_prepare("INSERT INTO as_comments (	topic_id,
															member_id,
															description,
															created_date)
													VALUES	(?,?,?,?)")
												->execute(	$_POST["topic_id"],
															$_POST["member_id"],
															$comment,
															$created_date);
															echo "2";
		header("Location: ../../detail-".$_POST['topic_id']."-".$_POST['title_seo'].".html?cp=yes&SV".$infosave);
	}
}
else{
	header("Location: ../../detail-".$_POST['topic_id']."-".$_POST['title_seo'].".html?cp=no");
}
?>