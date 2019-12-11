<?php
$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

define('GUI', $current_url);

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip_address = $_SERVER['HTTP_CLIENT_IP'];
}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
}else {
	$ip_address = $_SERVER['REMOTE_ADDR'];
}
$ip_addr = $class->clean($ip_address);
if(isset($_SESSION['banned']) && !empty($_SESSION['banned'])) {
	header('location : '.GUI.'/ban');
}
if (isset($_SESSION['banned']) && $_SESSION['banned'] == 'banned_user') {
	header('location: '.GUI.'/ban');
}

// error array list
$errors = array(
		'db_conn' => null,
		'up_err' => [
			'username' => 0,
			'email' => 0,
			'password_1' => 0,
			'password_2' => 0,
			'password' => 0,
			'first_name' => 0,
			'last_name' => 0,
			'date_of_birth' => 0,
			'country' => 0,
			'db_query' => 0,
			'ip' => 0
		],
		'up' => [
			'username' => null,
			'email' => null,
			'password_1' => null,
			'password_2' => null,
			'password' => null,
			'first_name' => null,
			'last_name' => null,
			'date_of_birth' => null,
			'country' => null,
			'db_query' => null,
			'ip' => null
		],
		'in' => [
			'email' => null,
			'password' => null,
			'backup' => null,
			'ip' => null
		],
		'in_err' => [
			'email' => 0,
			'password' => 0,
			'backup' => 0,
			'ip' => 0
		]
	); 


$sql = 'select ip from blacklist';
$blacklist = array();
$getIp = pg_query($db, $sql);
if (pg_num_rows($getIp) > 0) {
	$row = pg_fetch_all($getIp);
	foreach ($row as $key => $value['ip']) {
	  array_push($blacklist, $value['ip']);
	}
}

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
  $ip_address = $_SERVER['HTTP_CLIENT_IP'];
}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
}else {
  $ip_address = $_SERVER['REMOTE_ADDR'];
}
$ip_addr = $ip_address;

if(in_array($ip_address, $blacklist)) {
  $_SESSION['banned'] = 'banned_user';
    header('location: '.GUI.'/ban');
}

// try to make connection with DB -------------------------//-------------------------//-------------------------//
if (isset($_POST['signup'])) {	
	$username = $class->clean($_POST['username']);
	$email = $class->clean($_POST['email']);
	$password_1 = $class->clean($_POST['password']);
	$password_2 = $class->clean($_POST['c_password']);
	$first_name = $class->clean($_POST['first_name']);
	$last_name = $class->clean($_POST['last_name']);
	$birthday = $class->clean($_POST['date_of_birth']);
	$country = $class->clean($_POST['country']);
	unset($_SESSION['error_list']);

	if (empty($username)) { $errors['up']['username'] = "Username is required"; $errors['up_err']['username'] = 1; }
	if (empty($email)) { $errors['up']['email'] ="Email is required"; $errors['up_err']['email'] = 1; }
	if (empty($password_1)) { $errors['up']['password_1'] = "Password is required"; $errors['up_err']['password_1'] = 1; }
	if (empty($password_2)) { $errors['up']['password_2'] = "Password should confirm!"; $errors['up_err']['password_2'] = 1	; }
	if (empty($first_name)) { $errors['up']['password_2'] = "First name is required!"; $errors['up_err']['first_name'] = 1	; }
	if (empty($last_name)) { $errors['up']['password_2'] = "Last name is required!"; $errors['up_err']['last_name'] = 1	; }
	if (empty($birthday)) { $errors['up']['password_2'] = "Date of birth is required!"; $errors['up_err']['date_of_birth'] = 1	; }
	if (empty($country)) { $errors['up']['password_2'] = "Country name is required!"; $errors['up_err']['country'] = 1	; }
	if (strlen($username) > 31 || strlen($email) > 72 || strlen($password_1) > 72 || strlen($password_1) > 72 || strlen($first_name) > 47 || strlen($last_name) > 47 || strlen($birthday) > 10 || strlen($country) > 5) {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		$current_user = $class->clean($ip_address);
		try {
			pg_query($db, 'begin');
			$blacking = "INSERT INTO blacklist (ip) VALUES ('$current_user')";
			pg_query($db, $blacking);
			pg_query($db, 'commit');
		}catch (Exception $e) {
			$errors['up']['ip'] = 'Caught exception: '.$e->getMessage();
			$errors['up_err']['ip'] = 1;
		}
		$_SESSION['banned'] = 'banned_user';
		header('location: '.GUI.'/ban');
	}
	if ($password_1 != $password_2) {
		$errors['up']['password'] = "The two passwords do not match";
		$errors['up_err']['password'] = 1;
		$_SESSION['error_list'] = $errors['up'];
		header('location: /');
	}
	if (array_sum(array_values($errors['up_err'])) == 0) {
		$hash_uname = $class->enc($username);
		$hash_mail = $class->enc($email);
		$hash_pw = $class->enc($password_1);
		$hash_fn = $class->enc($first_name);
		$hash_ln = $class->enc($last_name);
		$hash_bd = $class->enc($birthday);
		$hash_ct = $class->enc($country);
		$ppic = '/assets/none.jpg';

		try {
			$query_begin = "begin";
			pg_query($db, $query_begin);
			$query_sql = "INSERT INTO users (username, email, password, first_name, last_name, date_of_birth, country, profile_picture) VALUES('$hash_uname', '$hash_mail', '$hash_pw', '$hash_fn', '$hash_ln', '$hash_bd', '$hash_ct', '$ppic')";
			pg_query($db, $query_sql);
			$query_commit = "commit";
			pg_query($db, $query_commit);
			$_SESSION['username'] = $username;
		} catch (Exception $e) {
			$errors['up']['db_query'] = 'Caught exception: '.$e->getMessage();
			$_SESSION['error_list'] = $errors['up'];
			header('location: /');
		}
		header('location: '.GUI.'/main');
	}
	header('location: /');
}

if (isset($_GET['signin'])) {
	$email = $class->clean($_GET['email']);
	$password = $class->clean($_GET['password']);
	unset($_SESSION['error_list']);
	if (empty($email)) {$errors['in']['email'] = "Email is required"; $errors['in_err']['email'] = 1;}
	if (empty($password)) {	$errors['in']['password'] = "Password is required";	$errors['in_err']['password'] = 1;	}
	if (strlen($email) > 72 || strlen($password) > 72 ) {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		$current_user = $class->clean($ip_address);
		try {
			pg_query($db, 'begin');
			$blacking = "INSERT INTO blacklist (ip) VALUES ('$current_user')";
			pg_query($db, $blacking);
			pg_query($db, 'commit');
		}catch (Exception $e) {
			$errors['in']['ip'] = 'Caught exception: '.$e->getMessage();
			$errors['in_err']['ip'] = 1;
		}
		$_SESSION['banned'] = 'banned_user';
		header('location: '.GUI.'/ban');
	}
	if (array_sum(array_values($errors['up_err'])) == 0) {
		$input = $password;
		$hash_mail = $class->enc($email);
		$hash_pw = $class->enc($input);
		try {
			pg_query($db, "begin");
			$query = "SELECT * FROM users WHERE email='$hash_mail' AND password='$hash_pw'";				
			$results = pg_query($db, $query) or die(pg_error($db));			
			pg_query($db, "commit");
		} catch (Exception $e) {
			$errors['in']['db_query'] = 'Caught exception: '.$e->getMessage();
			$_SESSION['error_list'] = $errors['in'];
			header('location: /');
		}
		if (pg_num_rows($results) == 1) {
			$row = pg_fetch_all($results);
			$user_info = array();
			foreach ($row as $key => $value) {
				array_push($user_info, $value);
			}
			$_SESSION['username'] = $class->dec($user_info[0]['username']);
			header('location: '.GUI.'/main/');
		}else {
			$errors['in']['backup'] = "Wrong email/password combination";
			$_SESSION['error_list'] = $errors['in'];
			header('location: /');
		}
	}
}
?>