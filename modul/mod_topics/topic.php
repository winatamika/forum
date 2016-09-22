<?php
$full_url = full_url();
echo "<br>";

$i = 1;

$sql_topic = $db->database_prepare("SELECT * FROM as_topics WHERE member_id = ? ORDER BY created_date DESC")->execute($_SESSION['member_login']);

$nums = format_hits($db->database_num_rows($sql_topics));

if ($q[1] != ''){
	echo "<span style='font-weight: bold; font-size: 16px;'>Forum Search Result</span><br>Search Result of <b>$q[1]</b> $nums Results found<br><br>";
}

echo "<table border='0' width='100%' class='tr' cellspacing='0'>
	<tr valign='top'>
		<td style='border-bottom: 1px solid rgba(255, 255, 255, 0.7); padding: 5px 3px 3px 10px; background-color: #4C66A4; color: #FFFFFF; font-weight: bold;' width='10'>No</td>
		<td style='border-bottom: 1px solid rgba(255, 255, 255, 0.7); padding: 5px 3px 3px 10px; background-color: #4C66A4; color: #FFFFFF; font-weight: bold;'>Last Topic</td>
		<td style='border-bottom: 1px solid rgba(255, 255, 255, 0.7); padding: 5px 3px 3px 0px; background-color: #4C66A4; color: #FFFFFF; font-weight: bold;'>Last Post</td>
		<td style='border-bottom: 1px solid rgba(255, 255, 255, 0.7); padding: 5px 3px 3px 0px; background-color: #4C66A4; color: #FFFFFF; font-weight: bold;'>Last Stats</td>
	</tr>
";

while ($data_topics = $db->database_fetch_array($sql_topic)){
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
			<td style='padding-top:15px; color: #666;'>$i</td>
			<td style='padding-top:15px; color: #666;' width='400'>
				<span style='font-weight: bold; font-size: 14px;'><a href='detail-$data_topics[topic_id]-$data_topics[title_seo].html' class='black'>$data_topics[title]</a></span>
			</td>
			<td style='padding-top:15px; color: #666;'>$comment_date</td>
			<td style='padding-top:15px; color: #666;'>$stat</td>
		</tr>
		<tr>
			<td colspan='4'><div style='border-bottom: 1px dotted #BBBBBB;'></div></td>
		</tr>";
	$i++;
}
echo "</table>";
?>