<?php 
session_start();
include('inner.php');
if (!isset($_SESSION['client'])) {
		header('location: /');
}
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['client']);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>DIGITID <?php echo date('Y')." | ".$cry->dec($profile['company_name']); ?></title>
	<link rel="stylesheet" type="text/css" href="css/diid.css">
	<meta name="viewport" content="width=device-width" />
	<meta name="theme-color" content="#ffffff" />
</head>
<body>
<div id="content" class="flex_row_center">
	<div id="wleft">
		<div id="user_panel">
			<img class="user_image" src="<?php echo $profile['profile_picture']; ?>">
			<div class="flex_row_center">
				<div class="di_stat">
					<div class="di_username"><?php echo $cry->dec($profile['company_name']);?></div>
					<div id="di_name" class="flex_row_center"><div><?php echo $cry->dec($profile['first_name']);?></div><div><?php echo $cry->dec($profile['last_name']);?></div></div>
				</div>
			</div>
		</div>
		<div class="drop_menu">
			<li class="link">balance : 0 $</li>
			<li class="link">digitid.me/pgnnet</li>
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
				<div id="di_title">Dashboard</div>
				<form id="search_box" class="flex_midle_center search_box" method="get" action="" autocomplete="off">
					<input id="input_field" class="google_sans input" type="text" name="q" placeholder="search" tabindex="1">
					<input type="submit" tabindex="2" value="S" class="search_button icon_font">
				</form>	
			</div>
			<!-- <div class="di_items flex_row">
				<div class="flex_row" style="z-index: 8;">
					<img class="di_items_logo" src="/assets/ApexS3.jpg">
				</div>
			</div>
			<div class="di_items flex_row">
				<div class="flex_row" style="z-index: 8;">
					<img class="di_items_logo" src="/assets/ApexS2.jpg">
				</div>
			</div>
			<div class="di_items flex_row">
				<div class="flex_row" style="z-index: 8;">
					<img class="di_items_logo" src="/assets/ApexS1.jpg">
				</div>
			</div> -->

		</div>
		<div id="copyright">&copy; 2019 DIGITID <?php echo isset($_SESSION['client']) ? $_SESSION['client'] : "none";?></div>
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
</script>
</body>
</html>