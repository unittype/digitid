<?php 
/*
DIGITID API 
*/
session_start();
include('classes.php');

$database = new DB();
$class = new AES();
$db = $database->getConnection();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");

if(isset($_GET['get_digitid']) && sizeof($_GET) == 3) :

	http_response_code(202);

	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip_address = $_SERVER['HTTP_CLIENT_IP'];
	}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else {
		$ip_address = $_SERVER['REMOTE_ADDR'];
	}
	$ip_addr = $class->clean($ip_address);

	// definition of DB connection

	$init_arr  = array(
			'id' => null,		
			'username' => null,
			'email' => null,
			'first_name' => null,
			'last_name' => null,
			'date_of_birth' => null,
			'phone' => null,
			'country' => null,
			'joined' => null,
			'picture' => 'assets/none.jpg',
			'is_member' => false
		);

	$req_uname = $class->enc($class->clean($_GET['username']));
	$req_pass = $class->enc($class->clean($_GET['password']));
	//$req_token = $class->enc($class->clean($_GET['token']));

	try {
		pg_query($db, "begin");
		$query = "SELECT * FROM users WHERE username = '$req_uname' AND password = '$req_pass'";				
		$results = pg_query($db, $query) or die(pg_error($db));			
		pg_query($db, "commit");
	} catch (Exception $e) {
		$e->getMessage();
	}
	if (pg_num_rows($results) == 1) {
		$row = pg_fetch_all($results);
		$user_info = array();
		foreach ($row as $key => $value) {
			array_push($user_info, $value);
		}
		$username = $class->dec($user_info[0]['username']);
		$email = $class->dec($user_info[0]['email']);
		$firs_name = $class->dec($user_info[0]['first_name']);
		$last_name = $class->dec($user_info[0]['last_name']);
		$country = $class->dec($user_info[0]['country']);

		// Successfull response

		http_response_code(200);
		echo json_encode([
			'ok' => true, '
			result' => [
				'username' => $username, 
				'email' => $email, 
				'firs_name' => $firs_name, 
				'last_name' => $last_name,
				'country' => $country,
				'avatar' => $class->resize_image($init_arr['picture'], 0.44)
				]
			]);
	}else {
		/// Error 404 Not Found
		http_response_code(404);
		echo json_encode(['ok' => false, 'error_code' => 404, 'description' => 'Not Found']);	
	}
/// Error 400 Bad Request
elseif(isset($_GET['get_digitid']) || sizeof($_GET) != 3) :
	http_response_code(400);
	echo json_encode(['ok' => false, 'error_code' => 400, 'description' => 'Bad Request']);
endif
?>
