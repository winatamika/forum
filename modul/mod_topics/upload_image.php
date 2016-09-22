<?php
session_start();
$uploaddir = '../../images/photo_topics/';
$file = $uploaddir .$_SESSION['email_login']."_".date('Ymdhis')."_".basename($_FILES['uploadfile']['name']); 
$file_name = $_SESSION['email_login']."_".date('Ymdhis')."_".$_FILES['uploadfile']['name']; 

if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
	echo "$file_name"; 
} 
else {
	echo "error";
}
?>