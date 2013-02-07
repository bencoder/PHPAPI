<?php
require_once("errors.php");

class helpers {
	
	static public function random_chars($len=10) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$i = 0;
		$pass = '' ;
		for ($i=0; $i <= $len;$i++) {
		    $num = rand(0,strlen($chars)-1);
		    $pass = $pass . $chars[$num];
		}
		return $pass;
	}
	
	function hash($password, $salt) {
		$to_hash = settings::site_salt.$password.$salt;
		$hashed  = hash("sha256", $to_hash);
		return $hashed;
	}

	function get_doc_comment($str, $tag = '') {
		if (empty($tag)) {
			return $str;
		}

		$matches = array();
		preg_match("/".$tag.":(.*)(\\r\\n|\\r|\\n)/U", $str, $matches);

		if (isset($matches[1])) {
			return trim($matches[1]);
		}

		return '';
	}
	
	// creates an error response (anything with a code != 0)
	function create_error($code) {
		return array(
			"code" => $code,
			"result" => errors::$errors[$code]);
	}
	
	// Creates a valid response(code 0)
	function create_response($details = "Success") {
		return array(
			"code" => 0,
			"result" => $details);
	}
	
	
	function cleandoc($doc) {
		$doclines = explode("\n", $doc);
		$results = array();
		foreach($doclines as $line) {
			if (stristr($line, '*')) continue;
			if (stristr($line, '@')) continue;
			$results[] = $line;
		}
		
		return implode("\n", $results);
	}
	
	private function __construct() {} //not constructable
}
