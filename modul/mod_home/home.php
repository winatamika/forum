<table>
	<tr valign="top">
		<td width='450' align="justify" style="padding-right: 30px;">
			<p style='font-weight: bold; font-size: 18px;'>NEW TOPICS</p>
			<?php
			$sql_topic = $db->database_prepare("SELECT * FROM as_topics ORDER BY created_date, topic_id DESC LIMIT 10")->execute();
			while ($dt_topic = $db->database_fetch_array($sql_topic)){
				echo "<p style='border-bottom: 1px solid #999999;'><a href='detail-$dt_topic[topic_id]-$dt_topic[title_seo].html' class='black'>$dt_topic[title]</a></p>";
			}
			?>
		</td>
		<td width='450' align="justify">
			<p style='font-weight: bold; font-size: 18px;'>HITS TOPIC</p>
			<?php
			$sql_topic = $db->database_prepare("SELECT * FROM as_topics ORDER BY hits DESC LIMIT 10")->execute();
			while ($dt_topic = $db->database_fetch_array($sql_topic)){
				echo "<p style='border-bottom: 1px solid #999999;'><a href='detail-$dt_topic[topic_id]-$dt_topic[title_seo].html' class='black'>$dt_topic[title] ($dt_topic[hits] times)</a></p>";
			}
			?>
		</td>
	</tr>
</table>