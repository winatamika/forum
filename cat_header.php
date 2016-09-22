<script src="js/jquery.min.js"></script>
<script src="js/jquery.selectric.min.js"></script>
<script>
	$(document).ready(function() {
		$('select.sort').selectric();
	});
	
	function sortfunction(sort){
		location.href = sort;
	}
</script>
<?php
$full_url = full_url();
$q = explode("?q=", $full_url);

if ($q[1] != ''){
	$k = "?q=".$q[1];
}
else{
	$k = "";
}

$nm = md5(date('Ymdhis'));
if ($_GET['id'] != 0 AND $_GET['cat'] == 0){
	$data_header = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_frm_categories WHERE frm_category_id = ? AND status = 'Y'")->execute($_GET["id"]));
	if ($data_header['image'] != ''){
		$image = "<img src='images/photo_forum/$data_header[image]' width='50' height='50'>";
	}
	else{
		$image = "<img src='images/no_image_2.jpg' width='50' height='50'>";
	}
	
	echo "<table style='padding-top: 10px; padding-bottom: 10px;'>
			<tr valign='top'>
				<td width='70'>$image</td>
				<td width='500'><span style='font-size: 24px;'>$data_header[category_name]</span> <br>
					<p>$data_header[description]</p>
				</td>
				<td style='padding-left: 20px;'>
					<table>
						<tr>
							<td><b>Information:</b></td>
						</tr>
						<tr>
							<td>
								<table>
									<tr>
										<td>Category</td>
										<td>:</td>
										<td>$data_header[category_name]</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
	</table>";
}

else{
	$data_header2 = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_frm_categories WHERE frm_category_id = ? AND status = 'Y'")->execute($_GET["id"]));
	$data_header = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_frm_sub_categories WHERE frm_sub_category_id = ? AND status = 'Y'")->execute($_GET["cat"]));
	if ($data_header['image'] != ''){
		$image = "<img src='images/photo_sub_forum/$data_header[image]' width='50' height='50'>";
	}
	else{
		$image = "<img src='images/no_image_2.jpg' width='50' height='50'>";
	}
	
	echo "<table style='padding-top: 10px; padding-bottom: 10px;'>
			<tr valign='top'>
				<td width='70'>$image</td>
				<td width='450'><span style='font-size: 24px;'>$data_header[category_name]</span> <br>
					<p>$data_header[description]</p>
				</td>
				<td style='padding-left: 20px;'>
					<table>
						<tr>
							<td><b>Search Info:</b></td>
						</tr>
						<tr>
							<td>
								<table>
									<tr>
										<td>Category</td>
										<td>:</td>
										<td>$data_header2[category_name] [Sub: $data_header[category_name]]</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
	</table>";
}
?>