<?php
error_reporting(0);
session_start();

include "config/class_database.php";
include "config/serverconfig.php";

$sql_country = $db->database_prepare("SELECT * FROM as_country WHERE region_id = ? AND status = 'Y'")->execute($_GET['region']);
if ($_SESSION['email_login'] == ''){
	echo "<option value='A'>All</option>";
}
else{
	echo "<option value=''>- Select Country -</option>";
}

while($k = $db->database_fetch_array($sql_country)){
    echo "<option value='$k[country_id]'>$k[country_name]</option>";
}
?>