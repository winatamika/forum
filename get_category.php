<?php
error_reporting(0);
session_start();

include "config/class_database.php";
include "config/serverconfig.php";

$sql_classified = $db->database_prepare("SELECT * FROM as_categories WHERE group_id = ? AND status = 'Y' ORDER BY category_name ASC")->execute($_GET['classified']);
if ($_SESSION['email_login'] == ''){
	echo "<option value='A'>All</option>";
}
else{
	echo "<option value=''>- Select Category -</option>";
}

while($k = $db->database_fetch_array($sql_classified)){
    echo "<option value='$k[category_id]'>$k[category_name]</option>";
}
?>