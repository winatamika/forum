<?php
session_start();
include "../../config/class_database.php";
include "../../config/serverconfig.php";
include "../../config/debug.php";
include "../../config/facebook/facebook.php";

$app_id = "255449991303140";
$secret_id = "fde2b94d49a1559c54ba706300b4a78f";

$facebook = new Facebook(array(
	'appId'  => $app_id,
	'secret' => $secret_id,
));

$user		= $facebook->getUser();
$get_data	= $facebook->api('/me', 'GET');
$created_date = date('Y-m-d H:i:s');
$first_name	= $get_data['first_name'];
$last_name	= $get_data['last_name'];
$email		= $get_data['email'];
$id			= $get_data['id'];
$bio		= htmlspecialchars($get_data['bio']);
$ip			= $_SERVER['REMOTE_ADDR'];


try 
{
	if($user)
	{
		$sql_user = $db->database_prepare("SELECT * FROM as_member WHERE email = ?")->execute($email);
		$num_user = $db->database_num_rows($sql_user);
		if ($num_user == 1){
			$db->database_prepare("UPDATE as_member SET last_login = ?, facebook_id = ? WHERE email = ?")->execute($created_date,$id,$email);
			$data = $db->database_fetch_array($db->database_prepare("SELECT username, member_id FROM as_member WHERE facebook_id = ?")->execute($id));
			
			$_SESSION['email_login'] = $email;
			$_SESSION['last_login'] = $created_date;
			$_SESSION['ip_login'] = $ip;
			$_SESSION['member_login'] = $data['member_id'];
			$_SESSION['username'] = $data['username'];
			$_SESSION["fb"] = "1";
		}
		else{
			$db->database_prepare("INSERT INTO as_member (facebook_id, email, first_name, last_name, biografi, status, created_date, last_login) VALUES(?,?,?,?,?,?,?,?)")
			->execute($id,$email,$first_name,$last_name,$bio,"Y",$created_date,$created_date);
			$insert_id = mysql_insert_id();
			
			$_SESSION['email_login'] = $email;
			$_SESSION['last_login'] = $created_date;
			$_SESSION['ip_login'] = $ip;
			$_SESSION['member_login'] = $insert_id;
			$_SESSION['username'] = "";
			$_SESSION['fb'] == "1";
		}
	}
}

//close bracket try
catch (facebookApiException $e) {
	error_log($e);
	$user = null;
}
?>