<?php
error_reporting(0);
session_start();
include "../../config/class_database.php";
include "../../config/serverconfig.php";

$msg_id = $_GET['message_id'];
$db->database_prepare("UPDATE as_messages SET status = 1 WHERE message_id = ?")->execute($msg_id);
?>