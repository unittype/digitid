<?php
/**
*
* class AES - Advmced Encryption, Authentication and Decryption
* class DB - database connection function for postgresql
*
*/
class AES{
	// Encryption method in two way
	private $encrypt_method = 'AES-256-CBC';
	// Private authentication key (don't use this in public production')
	private $secret_key = 'U2FsdGVkX1+kUKGvV1ZWDEgvixMXVv0XKCnbpN16gDA=';
	/*
	// Decryption funciton
	// return : plain text from sizeof(n).base64_encode
	*/
	public function dec($string) {
		$secret_iv = hash('sha256', $this->secret_key);
	  	$key = hash('sha256', $secret_iv);
		$initialization_vector = substr(hash('sha256', $secret_iv), 0, 16);
		return openssl_decrypt(base64_decode($string), $this->encrypt_method, $key, 0, $initialization_vector);
	}
	/*
	// Encryption funciton
	// return : sizeof(n).base64_encode from sizeof(n) plain text
	*/
	public function enc($string){
		$secret_iv = hash('sha256', $this->secret_key);
		$key = hash('sha256', $secret_iv);
		$initialization_vector = substr(hash('sha256', $secret_iv), 0, 16);
		$a = openssl_encrypt($string, $this->encrypt_method, $key, 0, $initialization_vector);
		return base64_encode($a);     
	}
	/*
	// User input escaping
	// return : plain text non-encoded char
	*/
	public function clean($string) {
		//Strip whitespacefrom the beginning and end of a string
		$string = trim($string);
		//Un-quotes a quoted string
		$string = stripslashes($string);
		//Convert special characters to HTML entities
		$string = htmlspecialchars($string);
		return $string;
	}
	/*
	// Resize and scaling images on pages
	*/
	public function resize_image($file, $percent) {
		$filename = $file;
		$percent = $percent;
		list($width, $height) = getimagesize($filename);
		$new_width = $width * $percent;
		$new_height = $height * $percent;
		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromjpeg($filename);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		ob_start();
		imagejpeg($image_p, null, 40);
		$r = 'data:image/jpeg;base64,'.base64_encode(ob_get_clean());
		imagedestroy($image_p);
		return $r;
	}
}

class DB {
	// Configuration is required
	private $host = 'localhost';
	private $port = '5432';
	private $password = '****';
	private $user = 'postgres';
	private $dbname = 'digitid';
	public $connection = null;
	/*
	// Return connection obj based on configurations
	*/
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
?>