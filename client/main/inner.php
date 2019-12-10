<?php
/**
* Database connection
*/
class DB {
	private $host = 'localhost';
	private $port = '5432';
	private $password = '9891';
	private $user = 'postgres';
	private $dbname = 'digitid';
	public $connection = null;


	public function getConnection(){
	    $this->connection = null;
	    try{
	        $this->connection = pg_connect('host='.$this->host.' port='.$this->port.' password='.$this->password.' user='.$this->user.' dbname='.$this->dbname.'');
	    }catch (Exception $e) {
			return $e->getMessage();
		}
	    return $this->connection;
	}
}

/**
*   AES encryption and authentication
*/
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
}

/**
* Class assignments
*/
$conn  = new DB();
$cry = new AES();

$blacklist = array();

$user = $cry->enc($_SESSION['client']);

$db = $conn->getConnection();
$sql = "select * from clients where company_name = '$user'";
$re = pg_query($db, $sql);
foreach ($row as $key => $value) {
  array_push($blacklist[$key] = $value);
}

if (pg_num_rows($re) == 1) {
	$row = pg_fetch_all($re);
	$results = array();
	foreach ($row as $key => $value) {
		array_push($results, $value);
	}
	pg_close($db);
	$ready = $results[0];
}

$profile  = array();
foreach ($ready as $key => $value) {
	$profile[$key] = $value;
}
?>
