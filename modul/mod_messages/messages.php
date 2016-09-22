<script>
	function checkAll(bx) {
		var cbs = document.getElementsByTagName('input');
		for(var i=0; i < cbs.length; i++) {
			if(cbs[i].type == 'checkbox') {
				cbs[i].checked = bx.checked;
			}
		}
	}
</script>
<style>
	.tr tr:hover {
		border-color: #DDDDDD;
		background: #eae7e7;
		color: #000;
	}
</style>
<?php
//include "rightmyads.php";
?>
<div class="main-column-wrapper2">
	<div class="main-column-left2">
		<div class="post-title2">
			<b>MESSAGES</b>
		</div>
		<?php
		$full_url = full_url();
		if (strpos($full_url, "?succ=ok") == TRUE){
			echo "<div class='messagesuccess' style='width: auto;'><p><b>Your message has been sent.</b></p></div>";
		}
		if (strpos($full_url, "?succ=canok") == TRUE){
			echo "<div class='messagesuccess' style='width: auto;'><p><b>Your message has been removed.</b></p></div>";
		}
		$num_messages_inbox = $db->database_num_rows($db->database_prepare("SELECT * FROM as_frm_messages WHERE sendto = ? AND status = 0")->execute($_SESSION["member_login"]));
		$num_messages_inbox_all = $db->database_num_rows($db->database_prepare("SELECT * FROM as_frm_messages WHERE sendto = ?")->execute($_SESSION["member_login"]));
		$num_messages_sentitem = $db->database_num_rows($db->database_prepare("SELECT * FROM as_frm_messages_sent WHERE msgfrom = ?")->execute($_SESSION["member_login"]));
		?>

		<div id="rotator2">  
			
			<ul class="ui-tabs-nav">  
			    <li <?php if ($_GET['div'] == 1){ echo "class='ui-tabs-selected1'"; } else { echo "class='ui-tabs-nav-item1'"; } ?>><a href="messages-1-1.html" class='black'><span>Inbox (<?php if ($num_messages_inbox > 0){ echo "<b>$num_messages_inbox</b>"; } else{ echo "0"; } ?> of <?php echo $num_messages_inbox_all; ?>)</span></a></li>  
			    <li <?php if ($_GET['div'] == 2){ echo "class='ui-tabs-selected2'"; } else { echo "class='ui-tabs-nav-item2'"; } ?>><a href="messages-2-1.html" class='black'><span>Sentitems (<?php if ($num_messages_sentitem > 0){ echo "$num_messages_sentitem"; } else{ echo "0"; } ?>)</span></a></li>
			</ul>
			
			<div id="fragment-1" class="ui-tabs-panel">
			<?php
			if ($_GET['div'] == 1){
			?>
				<form method='POST' action='modul/mod_messages/action_del_inbox.php'>
				<input type="hidden" name="div" value="1" />    
			    <table border="0" width="100%" class="tr" cellspacing="0">
			    	<tr bgcolor="#ccc">
			    		<th style='padding: 5px;' width="5%" align="center"><input type='checkbox' name='allbox' value='check' onclick='checkAll(this);' /></th>
			    		<th style='padding: 5px;' width="15%">Date</th>
			    		<th style='padding: 5px;' width="15%">From</th>
			    		<th style='padding: 5px;' width="45%">Subject</th>
			    		<th style='padding: 5px;' width="10%" align="center">Action</th>
			    	</tr>
			    	
				<?php
				$dataPerPage = 10;
				
				if(isset($_GET['page'])){
					$noPage = $_GET['page'];
				}
				else 
					$noPage = 1;

				$offset = ($noPage - 1) * $dataPerPage;
				
				$i = 1;
				$sql_ads = $db->database_prepare("SELECT A.message_id, A.subject, A.created_date, B.member_id, B.username, A.status, A.message, A.sendto, A.msgfrom
												FROM as_frm_messages A INNER JOIN as_member B ON B.member_id = A.msgfrom
												WHERE A.sendto = ? ORDER BY A.created_date DESC LIMIT $offset,$dataPerPage")->execute($_SESSION['member_login']);
				$num_ads = $db->database_num_rows($sql_ads);
				while ($data_ads = $db->database_fetch_array($sql_ads)){
					if ($data_ads['status'] == 1){
						echo "<tr valign='top' style='border-bottom: 1px solid #ccc;'>
							<td style='padding: 5px; text-align:center;'><input type='checkbox' name='check[]' value='$data_ads[message_id]'></td>
							<td style='padding: 5px;'>$data_ads[created_date]</td>
							<td style='padding: 5px;'>$data_ads[username]</td>
							<td style='padding: 5px;'>$data_ads[subject]</td>";
					}
					else{
						echo "<tr>
							<td style='padding: 5px; text-align:center;'><input type='checkbox' name='check[]' value='$data_ads[message_id]'></td>
							<td style='padding: 5px;'><b>$data_ads[created_date]</b></td>
							<td style='padding: 5px;'><b>$data_ads[username]</b></td>
							<td style='padding: 5px;'><b>$data_ads[subject]</b></td>";
					}
					echo "	<td style='padding: 5px; text-align: center;'>
								<a href='read-messages-$_GET[div]-$data_ads[message_id].html' class='black'><button type='button' class='button_profile'>Read</button></a>
							</td>
						</tr>";
					$i++;
				}
				?>
				</table>
				<br>
				<?php
				if ($num_ads > 0){
					echo "<input type='submit' name='submit' class='button_profile' value='DELETE'>";
				}
				?>
				</form>
				<table>
					<tr>
						<td>
							<div class="pagination">
								<?php
								$jumData	= $db->database_num_rows($db->database_prepare("SELECT * FROM as_frm_messages WHERE status = 0 AND sendto = ?")->execute($_SESSION["member_login"]));
								$jumPage = ceil($jumData/$dataPerPage);
				
								if ($noPage > 1)
									$numpage = $noPage-1;
									if ($numpage != ''){
										echo  "<a href='messages-1-$numpage.html' class='page'>&lt;&lt; Prev</a>";
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
												echo " <a href='messages-1-$page.html' class='page'>".$page."</a> ";
											$showPage = $page;
										}
									}
				
								if ($noPage < $jumPage)
									$numPlus = $noPage+1;
									if ($numPlus != ''){ 
										echo "<a href='messages-1-$numPlus.html' class='page'>Next &gt;&gt;</a>";
									}
									else{
										echo "<a href='#' class='page'>Next &gt;&gt;</a>";
									}
								?>
							</div>
						</td>
					</tr>
				</table>
			<!--</div>-->
			<?php
			}
			else{
			?>
				<form method='POST' action='modul/mod_messages/action_del_sentitem.php'>
				<input type="hidden" name="div" value="2" />    
			    <table border="0" width="100%" class="tr" cellspacing="0">
			    	<tr bgcolor="#ccc">
			    		<th style='padding: 5px;' width="5%" align="center"><input type='checkbox' name='allbox' value='check' onclick='checkAll(this);' /></th>
			    		<th style='padding: 5px;' width="15%">Date</th>
			    		<th style='padding: 5px;' width="15%">To</th>
			    		<th style='padding: 5px;' width="45%">Subject</th>
			    		<th style='padding: 5px;' width="10%" align="center">Action</th>
			    	</tr>
			    	
				<?php
				$dataPerPage = 10;
				
				if(isset($_GET['page'])){
					$noPage = $_GET['page'];
				}
				else 
					$noPage = 1;

				$offset = ($noPage - 1) * $dataPerPage;
				
				$i = 1;
				$sql_ads = $db->database_prepare("SELECT A.message_id, A.subject, A.created_date, B.member_id, B.username, A.message, A.sendto, A.msgfrom
												FROM as_frm_messages_sent A INNER JOIN as_member B ON B.member_id = A.sendto
												WHERE A.msgfrom = ? ORDER BY A.created_date DESC LIMIT $offset,$dataPerPage")->execute($_SESSION['member_login']);
				$num_ads = $db->database_num_rows($sql_ads);
				while ($data_ads = $db->database_fetch_array($sql_ads)){
					
					echo "<tr valign='top' style='border-bottom: 1px solid #ccc;'>
							<td style='padding: 5px; text-align:center;'><input type='checkbox' name='check[]' value='$data_ads[message_id]'></td>
							<td style='padding: 5px;'>$data_ads[created_date]</td>
							<td style='padding: 5px;'>$data_ads[username]</td>
							<td style='padding: 5px;'>$data_ads[subject]</td>
							<td style='padding: 5px; text-align: center;'>
								<a href='read-messages-$_GET[div]-$data_ads[message_id].html' class='black'><button type='button' class='button_profile'>Read</button></a>
							</td>
						</tr>";
					$i++;
				}
				?>
				</table>
				<br>
				<?php
				if ($num_ads > 0){
					echo "<input type='submit' name='submit' class='button_profile' value='DELETE'>";
				}
				?>
				</form>
				<table>
					<tr>
						<td>
							<div class="pagination">
								<?php
								$jumData	= $db->database_num_rows($db->database_prepare("SELECT * FROM as_frm_messages_sent WHERE msgfrom = ?")->execute($_SESSION["member_login"]));
								$jumPage = ceil($jumData/$dataPerPage);
				
								if ($noPage > 1)
									$numpage = $noPage-1;
									if ($numpage != ''){
										echo  "<a href='messages-2-$numpage.html' class='page'>&lt;&lt; Prev</a>";
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
												echo " <a href='messages-2-$page.html' class='page'>".$page."</a> ";
											$showPage = $page;
										}
									}
				
								if ($noPage < $jumPage)
									$numPlus = $noPage+1;
									if ($numPlus != ''){ 
										echo "<a href='messages-2-$numPlus.html' class='page'>Next &gt;&gt;</a>";
									}
									else{
										echo "<a href='#' class='page'>Next &gt;&gt;</a>";
									}
								?>
							</div>
						</td>
					</tr>
				</table>
			<?php	
			}
			?>
			</div>
		</div><!-- end rotator -->
	</div>
</div>