<?php
if ($_GET['module'] == 'home'){
	echo "<a href='home'>Home</a>";
}

elseif ($_GET['module'] == 'add-new-post'){
	echo "<a href='home'>Home</a> <font color='#999999'>></font> Add New Topic";
}

elseif ($_GET['module'] == 'detail-post'){
	echo "<a href='home'>Home</a> <font color='#999999'>></font> Topic Detail <font color='#999999'>></font>";
}

elseif ($_GET['module'] == 'cat_detail'){
	echo "<a href='home'>Home</a> <font color='#999999'>></font> Search Post by Country";
}
//comment section
?>
