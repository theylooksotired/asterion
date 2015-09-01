<?php
class Cookie {
	
	static public function get($name) {
		//Get a cookie value
		return (isset($_COOKIE[$name])) ? $_COOKIE[$name] : '';
	}

	static public function set($name, $value) {
		//Set a cookie value
		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
		setcookie($name, $value, time() + COOKIE_TIME, '/', $domain, false);
	}
	
	static public function delete($name) {
		//Delete a cookie
		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
		setcookie($name, '', time() - COOKIE_TIME, '/', $domain, false);
		unset($_COOKIE[$name]);
	}
	
}
?>