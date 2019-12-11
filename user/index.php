<?php
session_start();
$session_id = session_id();

include('classes.php');

$database = new DB();
$class = new AES();
$db = $database->getConnection();

include('load.php');

if (isset($_SESSION['username'])) {
		//unset($_SESSION['username']);
		header('location: main/');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>DITGITID | <?php echo date('Y'); ?></title>
	<link rel="stylesheet" type="text/css" href="css/welcome.css">
	<meta name="viewport" content="width=device-width" />
	<meta name="theme-color" content="#ffffff" />
</head>
<body>
<div id="small_back"></div>
<div id="content" class="flex_row_center">
	<div id="wleft" class="flex_col_center">	
		<div class="iconik"><svg viewBox="0 0 600 476" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M600 293H0V475.867H600V293ZM122.941 402.081C124.388 396.96 125.111 391.644 125.111 386.133C125.111 380.623 124.388 375.334 122.941 370.269C121.549 365.148 119.545 360.389 116.929 355.991C114.313 351.538 111.195 347.502 107.577 343.884C103.959 340.21 99.9235 337.065 95.4703 334.449C91.0172 331.833 86.2301 329.829 81.109 328.438C76.0436 326.99 70.7555 326.267 65.2448 326.267H29.1744V446H65.2448C70.7555 446 76.0436 445.304 81.109 443.913C86.2301 442.465 91.0172 440.434 95.4703 437.817C99.9235 435.201 103.959 432.084 107.577 428.466C111.195 424.792 114.313 420.756 116.929 416.359C119.545 411.906 121.549 407.146 122.941 402.081ZM101.148 386.133C101.148 381.179 100.202 376.531 98.3092 372.189C96.4723 367.848 93.9117 364.062 90.6276 360.834C87.399 357.55 83.5861 354.961 79.1886 353.069C74.8468 351.176 70.1989 350.23 65.2448 350.23H53.3048V422.037H65.2448C70.1989 422.037 74.8468 421.118 79.1886 419.281C83.5861 417.389 87.399 414.828 90.6276 411.6C93.9117 408.315 96.4723 404.502 98.3092 400.161C100.202 395.763 101.148 391.087 101.148 386.133ZM163.313 446H139.349V326.267H163.313V446ZM260.545 444.831C267.392 442.271 273.599 438.625 279.165 433.893V386.634H256.037V420.701C253.476 421.981 250.776 422.983 247.938 423.707C245.099 424.43 242.176 424.792 239.17 424.792C233.938 424.792 229.012 423.79 224.392 421.786C219.827 419.782 215.819 417.055 212.368 413.604C208.917 410.152 206.189 406.117 204.186 401.497C202.182 396.876 201.18 391.922 201.18 386.634C201.18 381.402 202.182 376.503 204.186 371.939C206.189 367.319 208.917 363.311 212.368 359.916C215.819 356.464 219.827 353.737 224.392 351.733C229.012 349.729 233.938 348.727 239.17 348.727C244.403 348.727 249.385 349.785 254.116 351.9C258.848 353.959 263.023 356.826 266.641 360.5L279.165 339.626C273.599 334.895 267.392 331.276 260.545 328.771C253.699 326.211 246.574 324.931 239.17 324.931C233.493 324.931 228.01 325.682 222.722 327.185C217.489 328.632 212.591 330.692 208.026 333.364C203.462 336.036 199.287 339.264 195.502 343.049C191.717 346.779 188.488 350.954 185.816 355.574C183.145 360.138 181.057 365.037 179.554 370.269C178.107 375.501 177.383 380.957 177.383 386.634C177.383 392.312 178.107 397.795 179.554 403.083C181.057 408.371 183.145 413.325 185.816 417.945C188.488 422.51 191.717 426.685 195.502 430.47C199.287 434.199 203.462 437.428 208.026 440.155C212.591 442.827 217.489 444.887 222.722 446.334C228.01 447.837 233.493 448.588 239.17 448.588C246.574 448.588 253.699 447.336 260.545 444.831ZM319.871 446H295.908V326.267H319.871V446ZM366.839 446H390.719V350.23H426.623V326.267H330.853V350.23H366.839V446ZM461.567 446H437.604V326.267H461.567V446ZM575.917 402.081C577.364 396.96 578.088 391.644 578.088 386.133C578.088 380.623 577.364 375.334 575.917 370.269C574.525 365.148 572.521 360.389 569.905 355.991C567.289 351.538 564.172 347.502 560.554 343.884C556.935 340.21 552.9 337.065 548.447 334.449C543.994 331.833 539.206 329.829 534.085 328.438C529.02 326.99 523.732 326.267 518.221 326.267H482.151V446H518.221C523.732 446 529.02 445.304 534.085 443.913C539.206 442.465 543.994 440.434 548.447 437.817C552.9 435.201 556.935 432.084 560.554 428.466C564.172 424.792 567.289 420.756 569.905 416.359C572.521 411.906 574.525 407.146 575.917 402.081ZM554.124 386.133C554.124 381.179 553.178 376.531 551.286 372.189C549.449 367.848 546.888 364.062 543.604 360.834C540.375 357.55 536.562 354.961 532.165 353.069C527.823 351.176 523.175 350.23 518.221 350.23H506.281V422.037H518.221C523.175 422.037 527.823 421.118 532.165 419.281C536.562 417.389 540.375 414.828 543.604 411.6C546.888 408.315 549.449 404.502 551.286 400.161C553.178 395.763 554.124 391.087 554.124 386.133Z" fill="#2F2F2F"/>
			<path d="M600 134.843C600 147.255 598.459 159.229 595.378 170.763C592.416 182.173 588.15 192.892 582.58 202.923C577.011 212.827 570.375 221.917 562.672 230.192C554.97 238.342 546.378 245.363 536.898 251.255C527.418 257.148 517.227 261.724 506.325 264.984C495.542 268.119 484.284 269.686 472.552 269.686H395.764V0H472.552C484.284 0 495.542 1.6299 506.325 4.8897C517.227 8.02412 527.418 12.5377 536.898 18.4304C546.378 24.3231 554.97 31.4069 562.672 39.6818C570.375 47.8313 577.011 56.9211 582.58 66.9513C588.15 76.8561 592.416 87.5758 595.378 99.1105C598.459 110.52 600 122.431 600 134.843ZM548.985 134.843C548.985 123.684 546.971 113.215 542.942 103.436C539.031 93.6566 533.58 85.1309 526.589 77.8591C519.716 70.4618 511.598 64.6318 502.237 60.369C492.994 56.1062 483.099 53.9748 472.552 53.9748H447.134V215.711H472.552C483.099 215.711 492.994 213.642 502.237 209.505C511.598 205.242 519.716 199.475 526.589 192.203C533.58 184.806 539.031 176.217 542.942 166.438C546.971 156.533 548.985 146.001 548.985 134.843Z" fill="#2F2F2F"/>
			<path d="M0 134.918C0 122.506 1.54796 110.532 4.64388 98.9976C7.62072 87.5883 11.9074 76.8686 17.5039 66.8384C23.1003 56.9337 29.7685 47.8438 37.5083 39.569C45.248 31.4195 53.8809 24.3984 63.4068 18.5056C72.9327 12.6129 83.1731 8.03666 94.1278 4.77686C104.964 1.64244 116.276 0.0752262 128.064 0.0752262H205.224V269.761H128.064C116.276 269.761 104.964 268.131 94.1278 264.871C83.1731 261.737 72.9327 257.223 63.4068 251.331C53.8809 245.438 45.248 238.354 37.5083 230.079C29.7685 221.93 23.1003 212.84 17.5039 202.81C11.9074 192.905 7.62072 182.185 4.64388 170.651C1.54796 159.241 0 147.33 0 134.918ZM51.2613 134.918C51.2613 146.077 53.2855 156.546 57.334 166.325C61.2635 176.104 66.7409 184.63 73.7662 191.902C80.6725 199.299 88.8291 205.129 98.2359 209.392C107.524 213.655 117.466 215.786 128.064 215.786H153.605V54.05H128.064C117.466 54.05 107.524 56.1187 98.2359 60.2562C88.8291 64.519 80.6725 70.2863 73.7662 77.5582C66.7409 84.9554 61.2635 93.5437 57.334 103.323C53.2855 113.228 51.2613 123.76 51.2613 134.918Z" fill="#2F2F2F"/>
			<path d="M312.077 0.0752262H366.394V269.686H312.077V0.0752262Z" fill="#2F2F2F"/>
			<path d="M232.082 0.0752262H286.399V269.686H232.082V0.0752262Z" fill="#2F2F2F"/>
			</svg>
		</div>
		<div class="copyright">&copy; DIGITID <?php echo date('Y'); ?> | KU License</div>
		<svg id="big_back"><circle cx="40%" cy="80%" r="56%" fill="#90E7ED" /></svg>
	</div>
	<div id="wright" class="flex_col_center">
		<svg id="small_back"><circle cx="90%" cy="90%" r="25%" fill="#E0FF22" /></svg>
		<form id="in" class="login_form" method="GET" action="/">
			<div class="message">SIGN IN</div>
			<div id="loginform" class="wide">
				<label>Email*</label>
				<div class="flex_row_space_between input">
					<input type="text" id="lun" class="input_type" name="email" autocomplete="off" minlength="5" maxlength="70" autofocus>
					<div class="valid valid_1 tooltip"></div>
				</div>
				<label>Password*</label>
				<div class="flex_row_space_between input">
					<input type="password" id="lpw" class="input_type" name="password" autocomplete="off" minlength="4" maxlength="50">
					<div class="valid  valid_2 tooltip"></div>
				</div>			
			</div>
			<button id="logbtn" name="signin" class="google_sans blue_button">continue</button>
			<div class="flex_row_space_between">
				<div class="offer" style="cursor: pointer;" onclick="tab();">CREATE ACCOUNT</div>
				<div class="asking" >forgot password?</div>
			</div>
		</form>
		<form id="up" class="signup_form" method="POST" action="/">
			<div class="message">SIGN UP</div>
			<div id="proc_a" class="wide">
				<label>Username*</label>
				<div class="flex_row_space_between input">
					<input type="text" id="sun" class="input_type" name="username" autocomplete="off"  maxlength="31">
					<div class="valid valid_3 tooltip"></div>
				</div>
				<label>Email*</label>
				<div class="flex_row_space_between input">
					<input type="text" id="smail" class="input_type" name="email" autocomplete="off"  minlength="5" maxlength="70">
					<div class="valid  valid_4 tooltip"></div>
				</div>
				<label>Password*</label>
				<div class="flex_row_space_between input">
					<input type="password" id="spw" class="input_type" name="password" autocomplete="off"  minlength="4" maxlength="50">
					<div class="valid  valid_5 tooltip"></div>
				</div>
				<label>Confirm Password*</label>
				<div class="flex_row_space_between input">
					<input type="password" id="scpw" class="input_type" name="c_password" autocomplete="off" minlength="4" maxlength="50">
					<div class="valid valid_6 tooltip"></div>
				</div>
			</div>
			<div id="proc_b" class="wide">
				<label>First name*</label>
				<div class="flex_row_space_between input">
					<input type="text" id="fn" class="input_type" name="first_name" autocomplete="off" minlength="1"  maxlength="47">
					<div class="valid valid_7 tooltip"></div>
				</div>					
				<label">Last name*</label>
				<div class="flex_row_space_between input">
					<input type="text" id="ln" class="input_type" name="last_name" autocomplete="off"  minlength="1" maxlength="47">
					<div class="valid  valid_8 tooltip"></div>
				</div>					
				<label>Date of birth [mm-dd-yyyy]*</label>
				<div class="flex_row_space_between input">
					<input type="date" id="bd" class="input_type" name="date_of_birth" autocomplete="off" required="required" min="01-01-1900" max="12-31-2019">
					<div class="valid  valid_9 tooltip"></div>
				</div>
				<label>Select country*</label>
				<div class="flex_row_space_between input">
					<select id="ct" class="input_type" name="country">
						<option value="all" selected='selected'>All</option>
						<option value="au">Australia</option>
						<option value="jp">Japan</option>
						<option value="kr">Korea</option>
						<option value="uk">UK</option>
						<option value="usa">USA</option>
					</select>
					<div class="valid valid_10 tooltip"></div>
				</div>				
			</div>
			<div class="flex_row_center">
				<div id="nextbtn" class="google_sans blue_button" onclick='next()' style="width:40%; margin-right: 5px;">next</div>
				<button id="upbtn" name="signup" class="google_sans blue_button">submit</button>				
			</div>
			<div class="flex_row_space_between">
				<div class="offer" style="cursor: pointer;" onclick="tab();">SIGN IN ACCOUNT</div>
				<div class="offer"></div>
			</div>
		</form>
		<div id="address" class="flex_row_center">
			<div class="tab">About</div>
			<div class="tab">API</div>
			<div class="tab">For business</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/welcome.js"></script>
</body>
</html>
