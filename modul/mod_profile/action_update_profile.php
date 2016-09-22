<?php
error_reporting(0);
session_start();
include "../../config/class_database.php";
include "../../config/serverconfig.php";

if ($_SESSION['email_login'] != ''){
	
	$modified_date = date('Y-m-d H:i:s');

	if ($_POST['filename'] != ''){
		$file = "../../images/photo_member/".$_POST['filename'];
		$gbr_asli = imagecreatefromjpeg($file);
		$lebar = imagesx($gbr_asli);
		$tinggi = imagesy($gbr_asli);
		
		$tum_lebar = 150;
		$tum_tinggi = 150;
		
		$gbr_thumb = imagecreatetruecolor($tum_lebar, $tum_tinggi);
		imagecopyresampled($gbr_thumb, $gbr_asli, 0, 0, 0, 0, $tum_lebar, $tum_tinggi, $lebar, $tinggi);
		
		imagejpeg($gbr_thumb, "../../images/photo_member/thumb/small_".$_POST['filename']);
		
		imagedestroy($gbr_asli);
		imagedestroy($gbr_thumb);
		
		$db->database_prepare("UPDATE as_member SET	photo = ?,
													first_name = ?,
													last_name = ?,
													province_id = ?,
													city_id = ?,
													cellphone = ?,
													hidden_cellphone = ?,
													ym_id = ?,
													address = ?,
													biografi = ?,
													modified_date = ?
													WHERE member_id = ?")
										->execute(	$_POST["filename"],
													$_POST["first_name"],
													$_POST["last_name"],
													$_POST["province"],
													$_POST["city"],
													$_POST["cellphone"],
													$_POST["hide_phone"],
													$_POST["ym_id"],
													$_POST["address"],
													$_POST["biografi"],
													$modified_date,
													$_SESSION["member_login"]);
	}
	
	else{
	
		$db->database_prepare("UPDATE as_member SET	first_name = ?,
													last_name = ?,
													province_id = ?,
													city_id = ?,
													cellphone = ?,
													hidden_cellphone = ?,
													ym_id = ?,
													address = ?,
													biografi = ?,
													modified_date = ?
													WHERE member_id = ?")
										->execute(	$_POST["first_name"],
													$_POST["last_name"],
													$_POST["province"],
													$_POST["city"],
													$_POST["cellphone"],
													$_POST["hide_phone"],
													$_POST["ym_id"],
													$_POST["address"],
													$_POST["biografi"],
													$modified_date,
													$_SESSION["member_login"]);
	}
	header("Location: ../../profile.html?suc=ok");
}
else{
	header("Location: ../../sign-in.html?err=log");
}
?>