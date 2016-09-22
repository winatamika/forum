<?php
error_reporting(0);
session_start();
include "../config/class_database.php";
include "../config/serverconfig.php";

$username = mysql_real_escape_string($_POST['username']);

if (preg_match('/^[a-zA-Z0-9]+$/', $username)){

	$nums = $db->database_num_rows($db->database_prepare("SELECT * FROM as_member WHERE username = ?")->execute($username));
	if ($nums == 0){
		$_SESSION['username'] = $username;
		$db->database_prepare("UPDATE as_member SET username = ? WHERE member_id = ?")->execute($username,$_SESSION["member_login"]);
		header("Location: home");
	}
	else{
		header("Location: profile.html?err=fail");
	}
}
else{
	header("Location: profile.html?err=noesc");
}
?>