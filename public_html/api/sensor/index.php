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
 * API for Sensor
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-msql/piomirrors.ini");

	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
//the array_key_exists returns true if the given key is set in the array from the documentation http://php.net/manual/en/function.array-key-exists.php

	//If method is post handle the sign in logic
	if($method === "POST") {

		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//create the sensor object
		//I picked sensorId not sure if this is correct
		$sensor = new Sensor(sensorId);

		//get the sensor information for the end user
		$sensorUnit = $sensorId->get('CO','SO2', 'NO2','PAHs','PM10','CH2O');
		// CO is carbon Monoxide
		// SO2 is sulfur dioxide
		// NO2 is nitrogen dioxide
		//PAHs polycyclic aromatic hydrocarbons
		//PM10 air pollution particle meter
		//CH2O is formaldhyde

		var_dump($sensorUnit);

	//get the sensor information for the end user

	} else {
		throw(new \InvalidArgumentException("invalid HTTP method request."));
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();

} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
echo json_encode($reply);