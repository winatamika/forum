<?php
error_reporting(0);
session_start();
include "../../config/class_database.php";
include "../../config/serverconfig.php";

if ($_SESSION['email_login'] != ''){
	$msg_id = $_POST['check'];
	$count = COUNT($msg_id);
	
	for ($i = 0; $i < $count; $i++){
		
		$db->database_prepare("DELETE FROM as_frm_messages_sent WHERE message_id = ?")->execute($msg_id[$i]);
	}
		
	header("Location: ../../messages-".$_POST['div']."-1.html?succ=canok");
}
?>