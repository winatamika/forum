<?php
error_reporting(0);
include "../../config/class_database.php";
include "../../config/serverconfig.php";

if(isset($_POST['username']))//If a username has been submitted
{
	$username = mysql_real_escape_string($_POST['username']);
	if (preg_match('/^[a-zA-Z0-9]+$/', $username)){
		$sql_username = $db->database_prepare("SELECT * FROM as_member WHERE username = ?")->execute($username);
		
		if ($db->database_num_rows($sql_username)){
			echo "1";
		}
		else{
			echo "0";
		}
	}
	else{
		echo "2";
	}
}
?>