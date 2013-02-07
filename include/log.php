<?php
/*
	Logging function that simply uses error_log. Log level in settings is used to 
	decide whether or not to log the message
*/

define("DEBUG", 100);
define("INFO", 10);
define("ERROR", 5);
define("FATAL", 1);

function do_log($msg, $level=DEBUG)
{
	if ($level <= settings::log_level) {
		$msg = preg_replace("/\s+/"," ",$msg);
		error_log($msg);
	}
	return;
}
