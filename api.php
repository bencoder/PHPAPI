<?php

require_once("include/settings.php");
require_once("include/log.php");
require_once("include/database.php");
require_once("include/controller.php");
require_once("include/errors.php");

class api_controller {

	function parse_uri($uri) {
		//converts the uri into a module name and a list of arguments to it.
	
		//try to get rid of the base dir if we're using one:
		if (settings::base != "") {
			$base = substr($uri, 0, strlen(settings::base));
			if ($base == settings::base) {
				$uri = substr($uri, strlen(settings::base));
			}
		}

		//get rid of starting slash if we have one.
		if ($uri[0] == '/') {
			$uri = substr($uri,1);
		}
		
		$parts = explode("/", $uri);

		//explode will return false if uri is empty, so make an empty array instead
		if (!is_array($parts)) {
			$parts = array();
		}
		
		$module = array_shift($parts);
		if (!$module) {
			//Should display the documentation for all the visible modules
			echo "not ready yet";
			exit();
		}

		return array($module, $parts);
	}

	function run_module($module, $args) {
		if (!file_exists("modules/$module.php")) {
			return false;
		}

		//include the file containing the module
		include_once("modules/$module.php");
		$class = $module."_api";
		if (!class_exists($class)) {
			return false;
		}

		$controller = new $class;

		return $controller->run($args);
	}
	
	function start() {
		$uri = $_SERVER['REQUEST_URI'];
		
		list($module, $args) = self::parse_uri($uri);

		$result = self::run_module($module, $args);
		
		if ($result === false || $result == null) {
			$result = helpers::create_error(1);
		}
		
		print json_encode($result);

	}

}

api_controller::start();
