<?php
require_once('settings.php');
require_once('log.php');
require_once('helpers.php');

class db {
	private static $db;
	
	
	static function init() {
		$dsn = 'mysql:dbname='.settings::dbname.';host='.settings::dbhost;
		$dbuser = settings::dbuser;
		$dbpass = settings::dbpass;
		try {
			self::$db = new PDO($dsn, $dbuser, $dbpass);
		} catch (PDOException $e) {
			do_log("Could not connect to db: ". $e->getMessage(), FATAL);
			exit();
		}
	}
	
	static function begin() {
		self::$db->beginTransaction();
		do_log("Starting transaction", INFO);
	}
	
	static function commit() {
		self::$db->commit();
		do_log("Committing transaction", INFO);
	}
	
	static function rollback() {
		self::$db->rollBack();
		do_log("Rolling back transaction", ERROR);
	}

	static function query($sql, $params=array(), $fetch=true) {
		do_log("Preparing and executing query: $sql with params: ".print_r($params,true), INFO);
		$stmt = self::$db->prepare($sql);
		if (!$stmt->execute($params)) {
			do_log("Error executing query ", ERROR);
			throw new Exception('Error executing query');
		}
		if ($fetch)
			return $stmt->fetchAll();
		else
			return $stmt;
	}
	

	private function __construct() {} //not constructable
}

db::init();
