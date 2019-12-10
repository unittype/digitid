<?php 
/*
DIGITID API 
*/
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");

if(isset($_GET['get_digitid']) && sizeof($_GET) == 3) :
http_response_code(202);
// Encription and Authentication
class AES
	{
		private $encrypt_method = 'AES-256-CBC';
		private $secret_key = 'U2FsdGVkX1+kUKGvV1ZWDEgvixMXVv0XKCnbpN16gDA=';

		public function dec($string) {
			$secret_iv = hash('sha256', $this->secret_key);
		  	$key = hash('sha256', $secret_iv);
			$initialization_vector = substr(hash('sha256', $secret_iv), 0, 16);
			return openssl_decrypt(base64_decode($string), $this->encrypt_method, $key, 0, $initialization_vector);
		}
		public function enc($string){
			$secret_iv = hash('sha256', $this->secret_key);
			$key = hash('sha256', $secret_iv);
			$initialization_vector = substr(hash('sha256', $secret_iv), 0, 16);
			$a = openssl_encrypt($string, $this->encrypt_method, $key, 0, $initialization_vector);
			return base64_encode($a);     
		}
		public function clean($string) {
			//Strip whitespacefrom the beginning and end of a string
			$string = trim($string);
			//Un-quotes a quoted string
			$string = stripslashes($string);
			//Convert special characters to HTML entities
			$string = htmlspecialchars($string);
			return $string;
		}
	}

	$class = new AES();

	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip_address = $_SERVER['HTTP_CLIENT_IP'];
	}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else {
		$ip_address = $_SERVER['REMOTE_ADDR'];
	}
	$ip_addr = $class->clean($ip_address);

	// definition of DB connection
	define('DB_HOST', 'localhost');
	define('DB_PORT', '5432');
	define('DB_PASSWD', '----');
	define('DB_USER', 'postgres');
	define('DB_NAME', 'digitid');
	try {
		$db = pg_connect('host='.DB_HOST.' port='.DB_PORT.' password='.DB_PASSWD.' user='.DB_USER.' dbname='.DB_NAME.'');
		if (!$db) {
			$errors['db_conn'] = 'DB refucing connection';
		}else{
			$errors['db_conn'] = null;		
		}
	} catch (Exception $e) {
		$errors['db_conn'] = 'Caught exception: '.$e->getMessage();
	}

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
				'avatar' => $init_arr['picture']
				]
			]);
	}else {
		/// Error 404 Not Found
		echo json_encode(['ok' => false, 'error_code' => 404, 'description' => 'Not Found']);	
	}
/// Error 400 Bad Request
elseif(!isset($_GET['get_digitid']) || sizeof($_GET) != 4) :
	http_response_code(404);
	echo json_encode(['ok' => false, 'error_code' => 400, 'description' => 'Bad Request']);		
endif
?>
