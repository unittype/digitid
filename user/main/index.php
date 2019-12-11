<?php 
session_start();
include('../classes.php');
$database = new DB();
$class = new AES();
$db = $database->getConnection();
include('inner.php');

if (!isset($_SESSION['username'])) {
		header('location: /');
}
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>DIGITID <?php echo date('Y')." | ".$class->dec($profile['username']); ?></title>
	<link rel="stylesheet" type="text/css" href="css/diid.css">
	<meta name="viewport" content="width=device-width" />
	<meta name="theme-color" content="#ffffff" />
	<script type="text/javascript">
	window.onload = function () {
		_('di_title').innerHTML = dash['title'];
		_('di_content').innerHTML = dash['content'];
	}
	</script>
</head>
<body>
<div id="content" class="flex_row_center">
	<div id="wleft">
		<div id="user_panel">
			<img class="user_image" src="<?php echo $profile['profile_picture']; ?>">
			<div class="flex_row_center">
				<div class="di_stat">
					<div class="di_username"><?php echo $class->dec($profile['username']);?></div>
					<div id="di_name" class="flex_row_center"><div><?php echo $class->dec($profile['first_name']);?></div><div><?php echo $class->dec($profile['last_name']);?></div></div>
				</div>
			</div>
		</div>
		<div class="drop_menu">
			<li class="link">balance : ----$</li>
			<li class="link">digitid.me/<?php echo $class->dec($profile['username']);?></li>
		</div>
		<div class="drop_menu">
			<ul>
				<li>Account</li>
				<li>Active Sessions</li>
				<li>Settings</li>
				<li onclick="logout();">Log out</li>
			</ul>
		</div>
	</div>
	<div id="wright" class="flex_col_center">
		<div class="container">
			<div id="head_top" class="flex_row_space_between">
				<div id="di_title"></div>
				<form id="search_box" class="flex_midle_center search_box" method="get" action="" autocomplete="off">
					<input id="input_field" class="google_sans input" type="text" name="q" placeholder="search" tabindex="1">
					<input type="submit" tabindex="2" value="S" class="search_button icon_font">
				</form>	
			</div>
			<div id="di_content">
				
			</div>
		</div>
		<div id="copyright">&copy; 2019 DIGITID</div>
	</div>
</div>
<script type="text/javascript">
function logout() {
	var ajax = new XMLHttpRequest();
	ajax.open('GET', '?logout', true);
	ajax.send();
	ajax.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			window.location.replace('/');
		}
	}
}
function _(e) {
	return document.getElementById(e);
}
</script>
<script type="text/javascript">
	var dash = {
	'title' : 'DASHBOARD',
	'content' : '<div class="di_items flex_row">\
			<div class="flex_row" style="z-index: 8;">\
				<img class="di_items_logo" src="/assets/ApexS3.jpg">\
			</div>\
		</div>\
		<div class="di_items flex_row">\
			<div class="flex_row" style="z-index: 8;">\
				<img class="di_items_logo" src="/assets/ApexS2.jpg">\
			</div>\
		</div>\
		<div class="di_items flex_row">\
			<div class="flex_row" style="z-index: 8;">\
				<img class="di_items_logo" src="/assets/ApexS1.jpg">\
			</div>\
		</div>'
	};
	var acc = {
		'title' : 'ACCOUNT',
		'content' : '<p>Username : <?php echo $class->dec($profile["username"]);?></p>\
					<p>id not available.</p>'
	};
	var sett = {
		'title' : 'SETTINGS',
		'content' : '<p>Username : <?php echo $class->dec($profile["username"]);?></p>\
					<p>id not available.</p>'
	};



</script>
</body>
</html>