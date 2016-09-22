<?php
session_start();
$uploaddir = '../../images/photo_member/'; 
$file = $uploaddir .$_SESSION['email_login']."_".basename($_FILES['uploadfile']['name']); 
$file_name= $_SESSION['email_login']."_".$_FILES['uploadfile']['name']; 

if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
	echo "$file_name"; 
} 
else {
	echo "error";
}
?>