<?php
	require_once("$Settings[MyDir]/class/Error.class.php");
	
	abstract class Cryptography
	{
		public static function hash($password, $cost=11)
		{
			self::checkAvailable();
			$salt=substr(base64_encode(openssl_random_pseudo_bytes(17)),0,22);
		    $salt=str_replace("+",".",$salt);
		    $param='$'.implode('$', array(
		    		"2y",
		    		str_pad($cost,2,"0",STR_PAD_LEFT),
		            $salt
		    ));
		    return crypt($password,$param);
		}
		public static function validate($password, $hash)
		{
			self::checkAvailable();
			return crypt($password, $hash)==$hash;
		}
		public static function checkAvailable()
		{
			if(CRYPT_BLOWFISH != 1)
				Error::assert("Your system doesn't support the BLOWFISH algorithm! This is needed to generate secure password hashes.", Error::getLastError());
		}
	}
		
?>
