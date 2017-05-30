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

/*
 * prepare an empty reply
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

	//determines which HTTP method needs to be used and processed comes as variable $method
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//stores the Primary key for the GET methods in $sensorId
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	// filter make sure it's a integer

	if($method === "GET"){
		//set XSRF cookie
		setXsrfCookie("/");
		//handle GET request - if id is present
		//determine if a Key was sent in the URL by checking $id. if so we pull the request
		if(empty($id) === false) {
			$reply-> data = Sensor::getSensorBySensorId($pdo, int)->toArray();
		}














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