<?php
if ($_GET['module'] == 'detail-post'){
	$detail = $db->database_fetch_array($db->database_prepare("SELECT title FROM as_topics WHERE topic_id = ?")->execute($_GET["id"]));
	echo "$detail[title] - Asfasolution.com";
}

elseif ($_GET['module'] == 'all-categories'){
	echo "All Categories Forum - Asfasolution.com";
}

elseif ($_GET['module'] == 'add-new-post'){
	echo "Add Your Post - Asfasolution.com";
}

elseif ($_GET['module'] == 'cat_detail'){
	if ($_GET['cat'] != '0' AND $_GET['id'] != '0'){
		$data_frm_title = $db->database_fetch_array($db->database_prepare("SELECT A.category_name, B.category_name as sub_category FROM as_frm_categories A INNER JOIN as_frm_sub_categories B ON B.frm_category_id=A.frm_category_id WHERE B.frm_sub_category_id = ?")->execute($_GET["cat"]));
		echo "$data_frm_title[category_name] - $data_frm_title[sub_category] - Asfasolution.com";
	}
	elseif ($_GET['cat'] == '0' AND $_GET['id'] != '0'){
		$data_frm_title = $db->database_fetch_array($db->database_prepare("SELECT A.category_name FROM as_frm_categories A WHERE A.frm_category_id = ?")->execute($_GET["id"]));
		echo "$data_frm_title[category_name] - Asfasolution.com";
	}
	else{
		if ($_GET['pid'] != '0'){
			$data_frm_title = $db->database_fetch_array($db->database_prepare("SELECT A.region_name, B.country_name, C.province_name FROM
																		as_region A LEFT JOIN as_country B ON A.region_id=B.region_id
																		LEFT JOIN as_provinces C ON C.country_id=B.country_id
																		WHERE C.province_id = ?")->execute($_GET["pid"]));
			echo "Forum Topics of $data_frm_title[region_name] - $data_frm_title[country_name] - $data_frm_title[province_name] - Asfasolution.com";
		}
		else{
			if ($_GET['cid'] != '0'){
				$data_frm_title = $db->database_fetch_array($db->database_prepare("SELECT A.region_name, B.country_name, C.province_name FROM
																			as_region A LEFT JOIN as_country B ON A.region_id=B.region_id
																			LEFT JOIN as_provinces C ON C.country_id=B.country_id
																			WHERE B.country_id = ?")->execute($_GET["cid"]));
				echo "Forum Topics of $data_frm_title[region_name] - $data_frm_title[country_name] - Asfasolution.com";
			}
			else{
				$data_frm_title = $db->database_fetch_array($db->database_prepare("SELECT A.region_name, B.country_name, C.province_name FROM
																			as_region A LEFT JOIN as_country B ON A.region_id=B.region_id
																			LEFT JOIN as_provinces C ON C.country_id=B.country_id
																			WHERE A.region_id = ?")->execute($_GET["rid"]));
				echo "Forum Topics of $data_frm_title[region_name] - Asfasolution.com";
			}
		}
	}
}

else{
	echo "Forum - Connecting Middle East Societies - Asfasolution.com";
}
?>