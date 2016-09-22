<p style="font-size: 20px;">All Forum Categories:</p>
<table>
	<tr valign="top">
		<?php
		$kolom = 4;
		$i = 0;
		$nm = md5(date('Ymdhis'));
		$sql_frm_cat = $db->database_prepare("SELECT * FROM as_frm_categories WHERE status = 'Y' ORDER BY category_name ASC")->execute();
		while ($data_frm_cat = $db->database_fetch_array($sql_frm_cat)){
			if ($i >= $kolom){
				echo "<tr></tr>";
				$i = 0;
			}
			$i++;
			echo "<td width='220'><b><a href='cat-detail-$data_frm_cat[frm_category_id]-0-1-$data_frm_cat[category_seo].html' class='black'>$data_frm_cat[category_name]</a></b><br>";
			
				$sql_sub_frm = $db->database_prepare("SELECT * FROM as_frm_sub_categories WHERE frm_category_id = ? AND status = 'Y' ORDER BY category_name ASC")->execute($data_frm_cat['frm_category_id']);
				while ($data_sub_frm = $db->database_fetch_array($sql_sub_frm)){
					echo "&bull; <a href='cat-detail-$data_frm_cat[frm_category_id]-$data_sub_frm[frm_sub_category_id]-1-$data_sub_frm[category_seo].html' class='black'>$data_sub_frm[category_name]</a> <br>";
				}
			echo "<br></td>";
		}
			?>
	</tr>
</table>