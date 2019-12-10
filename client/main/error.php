<?php 
session_start();

echo isset($_SESSION['error_list']) ? json_encode($_SESSION['error_list']) : "error list not detected!</br>";

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

$cry = new AES();

$a = 'VjdkQWk1bitGUm4rT0dBVG56aHRWQT09';

echo $cry->dec($a);

?>