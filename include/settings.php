<?php

require_once("log.php");

class settings {
	const dbuser = 'username';
	const dbpass = 'password';
	const dbhost = 'localhost';
	const dbname = 'database';

	const site_salt = 'heZMSDMEvuqVsFjddr';

	const base = '/'; // base directory
	
	const log_level = DEBUG;

	private function __construct() {} //not constructable
}
