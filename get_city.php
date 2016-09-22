<?php
error_reporting(0);
session_start();

include "config/class_database.php";
include "config/serverconfig.php";

$sql_city = $db->database_prepare("SELECT * FROM as_cities WHERE province_id = ? AND status = 'Y'")->execute($_GET['province']);
if ($_SESSION['email_login'] == ''){
	echo "<option value='A'>All</option>";
}
else{
	echo "<option value=''>- Select City -</option>";
}

while($k = $db->database_fetch_array($sql_city)){
    echo "<option value='$k[city_id]'>$k[city_name]</option>";
}
?>