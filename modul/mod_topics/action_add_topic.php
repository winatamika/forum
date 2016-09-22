<?php
error_reporting(0);
session_start();
include "../../config/class_database.php";
include "../../config/serverconfig.php";
include "../../config/fungsi_seo.php";
require_once('../../config/recaptcha/recaptchalib.php');

if ($_SESSION['email_login'] != ''){
	
	$privatekey = "6LeAdO8SAAAAAOsNGH6VBrhqDu07QYmrxMSNuBrF";
	$resp = recaptcha_check_answer ($privatekey,
	$_SERVER["REMOTE_ADDR"],
	$_POST["recaptcha_challenge_field"],
	$_POST["recaptcha_response_field"]);
	
	if (!$resp->is_valid){
		header("Location: ../../add-new-post.html?cp=no");
	}
	
	else{
		if ($_POST['filename'] != ''){
			$file = "../../images/photo_topics/".$_POST['filename'];
			$gbr_asli = imagecreatefromjpeg($file);
			$lebar = imagesx($gbr_asli);
			$tinggi = imagesy($gbr_asli);
			
			$tum_lebar = 150;
			$tum_tinggi = 150;
			
			$gbr_thumb = imagecreatetruecolor($tum_lebar, $tum_tinggi);
			imagecopyresampled($gbr_thumb, $gbr_asli, 0, 0, 0, 0, $tum_lebar, $tum_tinggi, $lebar, $tinggi);
			
			imagejpeg($gbr_thumb, "../../images/photo_topics/thumb/small_".$_POST['filename']);
			
			imagedestroy($gbr_asli);
			imagedestroy($gbr_thumb);
		}
		
		$ref_id = $_SESSION['member_login'].date('Ymdhis');
		$title_seo = seo_title($_POST['title']);
		$created_date = date('Y-m-d H:i:s');
		
		$cat = explode("-", $_POST['category']);
		
		$db->database_prepare("INSERT INTO as_topics (	topic_ref,
														title,
														title_seo,
														category_id,
														sub_category_id,
														description,
														image,
														member_id,
														created_date,
														modified_date,
														hits)
												VALUES	(?,?,?,?,?,?,?,?,?,?,?)")
											->execute(	$ref_id,
														$_POST["title"],
														$title_seo,
														$cat[0],
														$cat[1],
														$_POST["description"],
														$_POST["filename"],
														$_SESSION["member_login"],
														$created_date,
														"",
														0);
		$insert = mysql_insert_id();
		header("Location: ../../topic.html?save=ok?ref=".$ref_id);
	}
}
else{
	header("Location: ../../add-new-post.html?err=fail");
}
?>