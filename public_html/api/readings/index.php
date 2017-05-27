<?php
/**
 * Created by PhpStorm.
 * User: AmbientCreativiT
 * Date: 5/26/2017
 * Time: 11:38
 */
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\PiMirror\Reading;

/**
 * API for Reading Class
 * Sabastian Jackson w/ MatthewFischer
 */
// check the session status, if it is not active, start the session.
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
//create stdClass named $reply. this object will be used to store the results of the call to the api. sets status to 200 (success). creates data state variable, holds the result of the api call.
try {
	//grab the mySQL database connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/piomirrors.ini");
	//determines which HTTP Method needs to be processed and stores the result in $method
	$method = array_key_exists("HTTP_x_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//stores the Primary key for the GET methods in $id, This key will come in the URL sent by the front end. If no key is present $id will remain empty. Note that the input filtered.
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	//add a start mandate after?
	$sensorSunriseDateTime = filter_input(INPUT_GET, "$sensorSunriseDateTime");
	$sensorSunsetDateTime = filter_input(INPUT_GET, "$sensorSunsetDateTime");
	$pageNum = filter_input(INPUT_GET, "pageNum", FILTER_SANITIZE_NUMBER_INT);
	//page number
	if(empty($pageNum) === true || $pageNum < 0) {
		$pageNum = 0;
	}

//here we determine if the request received is a GET request
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie("/");
		//handle GET request - if id is present, that checkbook value is present, that checkbook value is returned, otherwise all values are returned.
		//determine is a Key was sent in the URL by checking $id. if so we pull the requested checkbook value by checkbook ID from the database and store it in $checkbook
		if(empty($id) === false) {
			$reply->data = Reading::getReadingByReadingSensorId($pdo, $id, $pageNum);
		} elseif(empty($sensorSunriseDateTime) === false && empty($sensorSunriseDateTime) === false) {
			$sensorSunriseDateTime = \DateTime::createFromFormat("U", floor
			($sensorSunriseDateTime / 1000 ));
			$sensorSunsetDateTime = \DateTime::createFromFormat("U", cell
			($sensorSunsetDateTime / 1000));
			reply->data = Reading::getReadingBySensorDateTime()Id
		}
	}
}
