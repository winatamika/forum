<?php 
session_start();
error_reporting(0);

// Panggil semua fungsi yang dibutuhkan (semuanya ada di folder config)
include "config/class_database.php";
include "config/serverconfig.php";
include "config/debug.php";
include "config/fungsi_rupiah.php";
include "config/fungsi_indotgl.php";
include "config/class_paging.php";
include "config/library.php";
include "config/fungsi_url.php";
include "config/facebook/facebook.php";

$des_ads = $db->database_fetch_array($db->database_prepare("SELECT meta_description FROM as_identity WHERE identity_id = ?")->execute(1));
$des = $des_ads['meta_description'];
$des_image = "";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="EN" lang="EN" dir="ltr">
	<head>
	<title><?php include "title.php"; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index, follow">
	<meta name="description" content="<?php echo $des; ?>">
	<meta name="keywords" content="<?php include "../keywords.php"; ?>">
	<meta http-equiv="Copyright" content="CV. ASFA Solution - www.asfasolution.com">
	<meta name="author" content="Agus Saputra - agus.saputra@asfasolution.com">
	<meta http-equiv="imagetoolbar" content="no">
	<meta name="language" content="English">
	<meta name="revisit-after" content="7">
	<meta name="webcrawlers" content="all">
	<meta name="rating" content="general">
	<meta name="spiders" content="all">
	
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="rss.xml" />
	
	<link rel="stylesheet" href="css/layout.css" type="text/css" />
	<link rel="stylesheet" href="css/paging.css" type="text/css" />
	<link rel="stylesheet" href="css/forum_navigation.css" type="text/css" />
	
	<!-- Homepage Specific Elements -->
	<script type="text/javascript" src="js/jquery-1.4.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
	<!--End Homepage Specific Elements -->
	
	<style type="text/css">
		.error {
			font-size:small; 
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
			border-color: #eed3d7;
			background-color: #b94a48;
			color: #FFFFFF;
			padding: 5px; 
			width: 266px;
			float: left;
		}
		
		.available {
			font-size:small; 
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
			border-color: #eed3d7;
			background-color: #008102;
			color: #FFFFFF;
			padding: 5px; 
			width: 266px;
			float:left;
		}
		
		.user_error {
			font-size:small; 
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
			border-color: #eed3d7;
			background-color: #b94a48;
			color: #FFFFFF;
			padding: 5px; 
			width: 266px;
		}
		
		.user_available {
			font-size:small; 
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
			border-color: #eed3d7;
			background-color: #008102;
			color: #FFFFFF;
			padding: 5px; 
			width: 266px;
		}
		
		#pageshare {position:fixed; top:35%; left:10px; float:left; border: 1px solid #CCCCCC; border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;background-color:#eff3fa;padding:0 0 2px 0;z-index:10;}
		
		#pageshare .sbutton {float:left;clear:both;margin:5px 5px 0 5px;}
		
		.fb_share_count_top {width:48px !important;}
		
		.fb_share_count_top, .fb_share_count_inner {-moz-border-radius:3px;-webkit-border-radius:3px;}
		
		.FBConnectButton_Small, .FBConnectButton_RTL_Small {width:49px !important; -moz-border-radius:3px;-webkit-border-radius:3px;}
		
		.FBConnectButton_Small .FBConnectButton_Text {padding:2px 2px 3px !important;-moz-border-radius:3px;-webkit-border-radius:3px;font-size:8px;}
	</style>
	
</head>

<body id="top">
	<div id="fb-root"></div>
	<script>
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	
<div id='pageshare' title="Share to Your Friends">
	<div class='sbutton' id='gb'>
		<div class="fb-like" data-href="http://www.oaseast.com/home" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div>
	</div>
	<div class='sbutton' id='rt'>
		<a href="http://www.oaseast.com/home" class="twitter-share-button" data-lang="en" data-count="vertical">Tweet</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>
</div>

<div id="navigation">
	<div id="navigation_wrap">
		<?php
		if ($_SESSION['email_login'] != ''){
			$name_login = $db->database_fetch_array($db->database_prepare("SELECT username,photo FROM as_member WHERE email = ?")->execute($_SESSION['email_login']));
		?>
			<!-- Start contact info area -->
			<div id="conteactinfo">
				<?php if ($name_login['photo'] != ''){
					echo "<img src='images/photo_member/thumb/small_$name_login[photo]' height='25' style='border-radius: 5px; border: 1px solid #ccc;'>";
				}
				?>
				<div style="padding-bottom: 10px; float:right; padding-left: 10px; margin-top: 2px;">Hi, <b><?php echo $name_login['username']; ?> </b></div>
			</div>
			<!-- End contact info area -->
			<!-- Start navigation -->
			<?php
			$num_messages_new = $db->database_num_rows($db->database_prepare("SELECT * FROM as_frm_messages WHERE sendto = ? AND status = 0")->execute($_SESSION["member_login"]));
			?>
			<div id="navi">
				<ul>
					<li><a href="home" title="Home">HOME</a></li>
					<li><a href="profile.html" title="Profile">PROFILE</a></li>
					<li><a href="all-categories.html" title="All Forum Categories">ALL CATEGORIES</a></li>
					<li><a href="messages-1-1.html" title="Messages">MESSAGES (<?php echo $num_messages_new; ?>)</a></li>
					<li><a href="logout.php" title="Sign Out">SIGN OUT</a></li>
				</ul>
			</div>
			<div id="conteactinfo2">
				<a href="add-new-post.html"><button type="button" class="freeads">ADD FORUM POST</button></a>
			</div>
			<!-- End navigation -->
		<?php
		}
		else{
		?>
			<div id="navi2">
				<ul>
					<li><a href="sign-in.html" title="Sign In">SIGN IN</a></li>
					<li><a href="sign-up.html" title="Sign Up">SIGN UP</a></li>
					<li><a href="all-categories.html" title="All Forum Categories">ALL CATEGORIES</a></li>
				</ul>
			</div>
		<?php
		}
		?>
	</div>
</div>


<div class="wrapper row1">
	<div id="header" class="clear">
		<div class="fl_left">
			<h1><a href="#"><img src="images/logo.jpg" height="75" width="300"></a></h1>
		</div>

		<div class="fl_right2">
			<div class="search">
				<form method="GET" action="search.php">
					<input type="hidden" name="id" value="<?php if ($_GET['id'] != 0){ echo $_GET['id']; } else{ echo "0"; } ?>" />
					<input type="hidden" name="page" value="1" />
					<input type="hidden" name="rid" value="<?php if ($_GET['rid'] != 0){ echo $_GET['rid']; } else{ echo "0"; } ?>" />
					<input type="hidden" name="cid" value="<?php if ($_GET['cid'] != 0){ echo $_GET['cid']; } else{ echo "0"; } ?>" />
					<input type="hidden" name="pid" value="<?php if ($_GET['pid'] != 0){ echo $_GET['pid']; } else{ echo "0"; } ?>" />
					<input type="hidden" name="cat" value="<?php if ($_GET['cat'] != 0){ echo $_GET['cat']; } else{ echo "0"; } ?>" />
					<input type="hidden" name="nm" value="<?php echo md5(date('Ymdhis')); ?>" />
					<input type="text" name="q" placeholder="Search post here...">
					<input type="submit" value="Search">
				</form>
			</div>
		</div>
	</div>
</div>

<!-- ####################################################################################################### -->
<div class="wrapper row2" style="border: 1px solid #CCCCCC;">
	
	<table align="center"><tr>
	<?php
	$sql_top_adv = $db->database_prepare("SELECT * FROM as_top_ads WHERE active = 'Y' ORDER BY rand() LIMIT 2")->execute();
	while($data_top_adv = $db->database_fetch_array($sql_top_adv)){
		echo "<td style='padding-right: 5px;'><a href='modul/mod_home/b.php?u=$data_top_adv[url]&id=$data_top_adv[top_ads_id]' title='$data_top_adv[title]' target='_blank'>
				<img src='images/top_adv/$data_top_adv[image]' border=0 width=450 height=90></a>
			</td>";
	}
	?>
	</tr></table>
</div>

<?php 
if ($_GET['module'] == 'cat_detail'){
	if ($_GET['id'] != 0 || $_GET['cat'] != 0){ 
?>
		<div class="wrapper3">
			<div class="rnd2">
				<div id="topnav2">
					<?php include "cat_header.php"; ?>
				</div>
			</div>
		</div>
<?php 
	}
} 
?>
<!-- ####################################################################################################### -->
<div class="wrapper row3">
	<?php if ($_GET['module'] != 'detail-post'){ ?>
	<div class="rnd">
		<div id="container" class="clear">
	<?php } ?>
			<!-- ####################################################################################################### -->
			<div id="homepage" class="clear">
				
				<?php
				
				include "content.php";
				?>
				<!-- ####################################################################################################### -->
				<!--<div id="twitter" class="clear">
					<div class="fl_left"><a href="#">Follow Us On Twitter</a></div>
					<div class="fl_right">Inteligula congue id elis donec sce sagittis intes id laoreet aenean. Massawisi condisse leo sem ac tincidunt nibh quis dui fauctor et donecnibh elis velit <a href="#">@name</a> - 10:15 AM yesterday</div>
				</div>-->

			<!-- ####################################################################################################### -->
		</div>
	<?php if ($_GET['module'] != 'detail-post'){ ?>
	</div>
</div>		<?php } ?>					
<!-- ####################################################################################################### -->

<div id="copyright" class="clear">
	<p class="fl_left"><br>Copyright &copy; <?php echo date('Y'); ?> - All Rights Reserved - <a href="#">asfasolution.co.id</a> </p>
</div>

</body>
</html>