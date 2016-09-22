<?php
include "right.php";
$full_url = full_url();
$q = explode("?q=", $full_url);

echo "<br>";

$dataPerPage = 15;

if(isset($_GET['page'])){
	$noPage = $_GET['page'];
}
else 
	$noPage = 1;

$offset = ($noPage - 1) * $dataPerPage;
$i = 1;

if ($_GET['cat'] != '0' && $_GET['id'] != '0'){
	
	if (strpos($full_url, "?q=") == TRUE){
		$explode = explode("+", $q[1]);
		$amount_word = (integer)count($explode);
		$jml_word = $amount_word - 1;
		
		$sql_topic = "SELECT * FROM as_topics WHERE ";
		
		for ($i = 0; $i <= $jml_word; $i++){
			$sql_topic .= " category_id = '$_GET[id]' AND sub_category_id = '$_GET[cat]' AND title LIKE '%$explode[$i]%'";
			if ($i < $jml_word){
				$sql_topic .= " OR ";
			}
		}
		
		$sql_topic .= " ORDER BY created_date DESC LIMIT $offset,$dataPerPage";
		
		$sql_topics = $db->database_prepare($sql_topic)->execute();
	}
	else{
		$sql_topics = $db->database_prepare("SELECT * FROM as_topics WHERE category_id = ? AND sub_category_id = ? ORDER BY created_date DESC LIMIT $offset,$dataPerPage")->execute($_GET['id'],$_GET['cat']);
	}
}
elseif ($_GET['id'] != '0' && $_GET['cat'] == '0'){
	if (strpos($full_url, "?q=") == TRUE){
		$explode = explode("+", $q[1]);
		$amount_word = (integer)count($explode);
		$jml_word = $amount_word - 1;
		
		$sql_topic = "SELECT * FROM as_topics WHERE ";
		
		for ($i = 0; $i <= $jml_word; $i++){
			$sql_topic .= " category_id = '$_GET[id]' AND title LIKE '%$explode[$i]%'";
			if ($i < $jml_word){
				$sql_topic .= " OR ";
			}
		}
		
		$sql_topic .= " ORDER BY created_date DESC LIMIT $offset,$dataPerPage";
		
		$sql_topics = $db->database_prepare($sql_topic)->execute();
	}
	else{
		$sql_topics = $db->database_prepare("SELECT * FROM as_topics WHERE category_id = ? ORDER BY created_date DESC LIMIT $offset,$dataPerPage")->execute($_GET['id']);	
	}
}
else{
	if (strpos($full_url, "?q=") == TRUE){
		$explode = explode("+", $q[1]);
		$amount_word = (integer)count($explode);
		$jml_word = $amount_word - 1;
		
		$sql_topic = "SELECT * FROM as_topics WHERE ";
		
		for ($i = 0; $i <= $jml_word; $i++){
			$sql_topic .= " sub_category_id = '$_GET[cat]' AND title LIKE '%$explode[$i]%'";
			if ($i < $jml_word){
				$sql_topic .= " OR ";
			}
		}
		
		$sql_topic .= " ORDER BY created_date DESC LIMIT $offset,$dataPerPage";
		
		$sql_topics = $db->database_prepare($sql_topic)->execute();
	}
	else{
		$sql_topics = $db->database_prepare("SELECT * FROM as_topics WHERE sub_category_id = ? ORDER BY created_date DESC LIMIT $offset,$dataPerPage")->execute($_GET['cat']);
	}
}

$nums = format_hits($db->database_num_rows($sql_topics));

if ($q[1] != ''){
	echo "<span style='font-weight: bold; font-size: 16px;'>Forum Search Result</span><br>Search Result of <b>$q[1]</b> $nums Results found<br><br>";
}

echo "<table border='0' width='690px' class='tr' cellspacing='0'>
	<tr valign='top'>
		<td style='border-bottom: 1px solid rgba(255, 255, 255, 0.7); padding: 5px 3px 3px 10px; background-color: #4C66A4; color: #FFFFFF; font-weight: bold;'>Last Topic</td>
		<td style='border-bottom: 1px solid rgba(255, 255, 255, 0.7); padding: 5px 3px 3px 0px; background-color: #4C66A4; color: #FFFFFF; font-weight: bold;'>Last Post</td>
		<td style='border-bottom: 1px solid rgba(255, 255, 255, 0.7); padding: 5px 3px 3px 0px; background-color: #4C66A4; color: #FFFFFF; font-weight: bold;'>Last Stats</td>
	</tr>
";

while ($data_topics = $db->database_fetch_array($sql_topics)){
	
	$user = $db->database_fetch_array($db->database_prepare("SELECT username, member_id FROM as_member WHERE member_id = ?")->execute($data_topics['member_id']));
	$sql_comment = $db->database_prepare("SELECT A.created_date, B.member_id, B.username FROM as_comments A LEFT JOIN as_member B ON B.member_id=A.member_id WHERE A.topic_id = ? ORDER BY A.created_date DESC")->execute($data_topics['topic_id']);
	$comment = $db->database_num_rows($sql_comment);
	$data_comment = $db->database_fetch_array($sql_comment);
	
	$ex = explode(" ", $data_comment['created_date']);
	$ex_min = explode("-", $ex[0]);
	$comment_date = $ex_min[0]."-".$ex_min[1]."-".$ex_min[2]." ".$ex[1];
	$hits = format_hits($data_topics['hits']);
	$replies = format_hits($comment);
	
	if ($comment > 0){
		$comment_date = $comment_date."<br>by <a href='profile-$user[member_id]-$user[username].html' class='blue'>$user[username]</a>";
		$stat = "Replies: $replies<br>Views: <b>$hits</b>";
	}
	else{
		$comment_date = "-";
		$stat = "Replies: $replies<br>Views: <b>$hits</b>";
	}

	echo "<tr valign='top' style='border-bottom: 1px solid #ccc;'>
			<td style='padding-top:15px; color: #666;' width='400'>
				<span style='font-weight: bold; font-size: 14px;'><a href='detail-$data_topics[topic_id]-$data_topics[title_seo].html' class='black'>$data_topics[title]</a></span><br>
				by <a href='profile-$user[member_id]-$user[username].html' class='blue'>$user[username]</a>
			</td>
			<td style='padding-top:15px; color: #666;'>$comment_date</td>
			<td style='padding-top:15px; color: #666;'>$stat</td>
		</tr>
		<tr>
			<td colspan='3'><div style='border-bottom: 1px dotted #BBBBBB;'></div></td>
		</tr>";
	$i++;
}
echo "</table>
<br>
<table align='right'>
	<tr>
		<td>
			<div class='pagination'>";
			
				if ($_GET['cat'] != '0' && $_GET['id'] != '0'){
					if (strpos($full_url, "?q=") == TRUE){
						$explode = explode("+", $q[1]);
						$amount_word = (integer)count($explode);
						$jml_word = $amount_word - 1;
						
						$sql_jum = "SELECT * FROM as_topics WHERE ";
						
						for ($i = 0; $i <= $jml_word; $i++){
							$sql_jum .= " category_id = '$_GET[id]' AND sub_category_id = '$_GET[cat]' AND title LIKE '%$explode[$i]%'";
							if ($i < $jml_word){
								$sql_jum .= " OR ";
							}
						}
						
						$sql_jum .= "";
						
						$jumData = $db->database_num_rows($db->database_prepare($sql_jum)->execute());
					}
					else{
						$jumData	= $db->database_num_rows($db->database_prepare("SELECT * FROM as_topics WHERE category_id = ? AND sub_category_id = ?")->execute($_GET['id'],$_GET['cat']));
					}
				}
				
				elseif ($_GET['id'] != '0' && $_GET['cat'] == '0'){
					if (strpos($full_url, "?q=") == TRUE){
						$explode = explode("+", $q[1]);
						$amount_word = (integer)count($explode);
						$jml_word = $amount_word - 1;
						
						$sql_jum = "SELECT * FROM as_topics WHERE ";
						
						for ($i = 0; $i <= $jml_word; $i++){
							$sql_jum .= " category_id = '$_GET[id]' AND title LIKE '%$explode[$i]%'";
							if ($i < $jml_word){
								$sql_jum .= " OR ";
							}
						}
						
						$sql_jum .= "";
						
						$jumData = $db->database_num_rows($db->database_prepare($sql_jum)->execute());
					}
					else{
						$jumData	= $db->database_num_rows($db->database_prepare("SELECT * FROM as_topics WHERE category_id = ?")->execute($_GET['id']));
					}
				}
				else{
					if (strpos($full_url, "?q=") == TRUE){
						$explode = explode("+", $q[1]);
						$amount_word = (integer)count($explode);
						$jml_word = $amount_word - 1;
						
						$sql_jum = "SELECT * FROM as_topics WHERE ";
						
						for ($i = 0; $i <= $jml_word; $i++){
							$sql_jum .= " sub_category_id = '$_GET[cat]' AND title LIKE '%$explode[$i]%'";
							if ($i < $jml_word){
								$sql_jum .= " OR ";
							}
						}
						
						$sql_jum .= "";
						
						$jumData = $db->database_num_rows($db->database_prepare($sql_jum)->execute());
					}
					else{
						$jumData	= $db->database_num_rows($db->database_prepare("SELECT * FROM as_topics WHERE sub_category_id = ?")->execute($_GET['cat']));
					}
				}
				
				$jumPage = ceil($jumData/$dataPerPage);
							
				if ($noPage > 1)
					$numpage = $noPage-1;
					if ($numpage != ''){
						if (strpos($full_url, "?q=") == TRUE){
							echo  "<a href='cat-detail-$_GET[id]-$_GET[cat]-$numpage-$_GET[nm].html?q=$q[1]' class='page'>&lt;&lt; Prev</a>";
						}
						else{
							echo  "<a href='cat-detail-$_GET[id]-$_GET[cat]-$numpage-$_GET[nm].html' class='page'>&lt;&lt; Prev</a>";
						}
					}
					else{
						echo  "<a href='#' class='page'>&lt;&lt; Prev</a>";
					}
					for($page = 1; $page <= $jumPage; $page++){
						if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage)){
							if (($showPage == 1) && ($page != 2))  
								echo "...";
							if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  
								echo "...";
							if ($page == $noPage) 
								echo " <span class='page active'>".$page."</span> ";
							else
								if (strpos($full_url, "?q=") == TRUE){ 
									echo " <a href='cat-detail-$_GET[id]-$_GET[cat]-$page-$_GET[nm].html?q=$q[1]' class='page'>".$page."</a> ";
								}
								else{
									echo " <a href='cat-detail-$_GET[id]-$_GET[cat]-$page-$_GET[nm].html' class='page'>".$page."</a> ";
								}
							$showPage = $page;
						}
					}
				
				if ($noPage < $jumPage)
					$numPlus = $noPage+1;
					if ($numPlus != ''){
						if (strpos($full_url, "?q=") == TRUE){  
							echo "<a href='cat-detail-$_GET[id]-$_GET[cat]-$numPlus-$_GET[nm].html?q=$q[1]' class='page'>Next &gt;&gt;</a>";
						}
						else{
							echo "<a href='cat-detail-$_GET[id]-$_GET[cat]-$numPlus-$_GET[nm].html' class='page'>Next &gt;&gt;</a>";
						}
					}
					else{
						echo "<a href='#' class='page'>Next &gt;&gt;</a>";
					}
				?>
			</div>
		</td>
	</tr>
</table>