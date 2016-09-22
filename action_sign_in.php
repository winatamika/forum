<?php
error_reporting(0);
include "config/class_database.php";
include "config/serverconfig.php";

$passwd = md5($_POST['password']);
$sql_sign_in = $db->database_prepare("SELECT * FROM as_member WHERE email = ? AND password = ? AND status = 'Y'")->execute($_POST['email'],$passwd);
$nums = $db->database_num_rows($sql_sign_in);
$data = $db->database_fetch_array($sql_sign_in);
$last_login = date('Y-m-d H:i:s');
$ip = $_SERVER['REMOTE_ADDR'];
$email = explode("@", $_POST['email']);

if ($nums > 0){
	session_start();
	
	$_SESSION['email_login'] = $_POST['email'];
	$_SESSION['last_login'] = $last_login;
	$_SESSION['ip_login'] = $ip;
	$_SESSION['member_login'] = $data['member_id'];
	$_SESSION['username'] = $data['username'];
	$_SESSION['fb'] == "";
	
	$db->database_prepare("UPDATE as_member SET last_login = ?, ip = ? WHERE email = ?")->execute($last_login,$ip,$_POST['email']);
	
	header("Location: profile.html");
}
else{
	header("Location: sign-in.html?err=error_log");
}
?>