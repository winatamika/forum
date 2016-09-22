<?php
$q = str_replace(" ", "+", $_GET['q']);
header("Location: cat-detail-".$_GET['id']."-".$_GET['page']."-".$_GET['rid']."-".$_GET['cid']."-".$_GET['pid']."-".$_GET['cat']."-".$_GET['nm'].".html?q=".$q);
?>