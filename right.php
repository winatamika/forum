<link rel="stylesheet" type="text/css" media="all" href="js/fancybox/jquery.fancybox.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="js/fancybox/jquery.fancybox.js?v=2.0.6"></script>
<link rel="stylesheet" href="css/jquery-tab.css" type="text/css" />
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.selectric.min.js"></script>

<div id="left_column">
	<?php
	if ($_GET['module'] == 'cat_detail'){
	?>
	
	<link rel="stylesheet" href="css/jquery.treeview.css" />
	<script src="js/jquery.treeview.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(function() {
			$("#tree_menu").treeview({
				collapsed: true,
				animated: "medium",
				persist: "location"
			});
		})
		
	</script>
	
	<div id="sidetree" style="width: 230px; float: left;">
		<p style="font-weight: bold; font-size: 16px;">All Categories:</p>
		
		<ul id="tree_menu">
			<?php
			$sql = $db->database_prepare("SELECT * FROM as_frm_categories WHERE status = 'Y' ORDER BY category_name ASC")->execute();
			while ($data = $db->database_fetch_array($sql)){
				
				$nums = $db->database_num_rows($db->database_prepare("SELECT * FROM as_frm_sub_categories WHERE frm_category_id = ? AND status = 'Y'")->execute($data['frm_category_id']));
				if ($nums > 0){
					echo "<li><a href='cat-detail-$data[frm_category_id]-0-1-$data[category_seo].html' class='black'><strong>$data[category_name]</strong></a><ul>";
					$sql_ct = $db->database_prepare("SELECT * FROM as_frm_sub_categories WHERE frm_category_id = ? AND status = 'Y' ORDER BY category_name ASC")->execute($data['frm_category_id']);
					while ($data_ct = $db->database_fetch_array($sql_ct)){
						echo "<li><a href='cat-detail-$data[frm_category_id]-$data_ct[frm_sub_category_id]-1-$data_ct[category_seo].html' class='black'>$data_ct[category_name]</a></li>";
					}
					echo "</ul></li>";
				}
				else{
					echo "<li><li><a href='cat-detail-$data[frm_category_id]-0-1-$data[category_seo].html' class='black'><strong>$data[category_name]</strong></a></li>";
				}
			}
			?>
		</ul>
	</div>
		<br>
	<?php
	}
	?>
</div>