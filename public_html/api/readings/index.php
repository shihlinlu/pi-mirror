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
			$reply->data = Reading::getReadingByReadingSensorId($pdo, $id, $pageNum)->toArray();
		} elseif(empty($sensorSunriseDateTime) === false && empty($sensorSunriseDateTime) === false) {
			$sensorSunriseDateTime = \DateTime::createFromFormat("U", floor
			($sensorSunriseDateTime / 1000));
			$sensorSunsetDateTime = \DateTime::createFromFormat("U", cell
			($sensorSunsetDateTime / 1000));
			$reply->data = Reading::getReadingBySensorDateTime($pdo, $sensorSunriseDateTime, $sensorSunsetDateTime, $pageNum)->toArray();
		} else {
			$sensorReadings = Reading::getAllReadings($pdo, $pageNum)->toArray();
			if($sensorReadings !== null) {
				$reply->data = $sensorReadings;
			}
		}
	}  else if($method === "POST") {
// this line determines if the request is a POST request
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);
		if(empty($requestObject->criteriaFieldId) === true) {
			throw(new \InvalidArgumentException ("No Criteria Field IdL", 405));
		}
		if(empty($requestObject->criteriaShareId) === true) {
			throw(new \InvalidArgumentException ("No Criteria Share Id", 405));
		}
		if(empty($requestObject->criteriaOperator) === true) {
			throw(new \InvalidArgumentException ("Y U NO use right operator", 405));
		}
		if(empty($requestObject->criteriaValue) === true) {
			throw(new \InvalidArgumentException ("Where's the value in that?", 405));
		}
		// creates a new Criteria object and stores it in $criteria
		$criteria = new Criteria(null, $requestObject->criteriaFieldId, $requestObject->criteriaShareId, $requestObject->criteriaOperator, $requestObject->criteriaValue);
		// calls the INSERT method in $criteria which inserts the object into the DataBase.
		$criteria->insert($pdo);
		// stores the "Criteria created OK" message in the $reply->message state variable.
		$reply->message = "Criteria OK";
	}  else {
		throw (new InvalidArgumentException("Invalid HTTP Method Request"));
		// If the method request is not GET, PUT, POST, or DELETE, an exception is thrown
	} 
}
catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
// in these lines the Exceptions are caught and the $reply object is updated with the data from the caught exception. Note that $reply->status will be updated with the correct error code in the case of an Exception
header("Content-type: application/json");
//sets up the response header.
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);
//finally - JSON encodes the $reply object and sends it back to the front end.