<?php
error_reporting(0);
include "../../config/class_database.php";
include "../../config/serverconfig.php";

if(isset($_POST['email']))//If a username has been submitted
{
	$email = mysql_real_escape_string($_POST['email']);
	if (filter_var($email, FILTER_VALIDATE_EMAIL)){
		$sql_sign_up = $db->database_prepare("SELECT * FROM as_member WHERE email = ?")->execute($email);
		
		if ($db->database_num_rows($sql_sign_up)){
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