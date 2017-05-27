<?php
require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__,3)."/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3)."/vendor/autoload.php";

/**
 * not sure if this is use function's path is correct
 */
use Edu\Cnm\PiMirror\Sensor;

/**
 * API for Sensors
 * @author Shihlin Lu
 * @author Danielle Martin
 */
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	//grab mySQL statement
	$config = readConfig("/etc/apache2/capstone-msql/piomirrors.ini");

	//variable that will house the API key for the sensor
	$sensor = $config["sensor"];

	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
//the array_key_exists returns true if the given key is set in the array from the documentation http://php.net/manual/en/function.array-key-exists.php

}