<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");



use Forecast\Forecast;
/**
 * api for current weather
 *
 * @author Tucker (Github)
 **/

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
		//initialize encrypted config variable
		//config is reading
		//although the name does not match the database this is correct per bridge's example
		$config = readConfig("/etc/apache2/capstone-mysql/piomirrors.ini");
	
	}

	//grab mySQL statement
	//pdo is reading and writing
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/pimirrors.ini");
	
	//variable that will house the API key for the Dark Sky API
	$darkSky = $config["darkSky"];
	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//If method is post handle the sign in logic
	if($method === "POST") {
		//make sure the XSRF Token is valid.
		verifyXsrf();

		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//Latitude provided vy user's browser
		$userLocationX = filter_var($requestObject->userLocationX, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
		if(empty($requestObject->userLocationX) === true) {
			throw(new \InvalidArgumentException("Currently disconnected", 401));
		}

		//Longitude provided by user's browser
		$userLocationY = filter_var($requestObject->userLocationY, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
		if(empty($requestObject->userLocationY) === true) {
			throw(new \InvalidArgumentException("Currently disconnected", 401));
		}

		//TODO used only for testing latitude and longitude results. Remove prior to final deployment
		var_dump($userLocationX);
		var_dump($userLocationY);
	}
	/*
	//grab the profile from the database by the email provided
	$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
	if(empty($profile) === true) {
		throw(new \InvalidArgumentException("Invalid Email", 401));
	}
	*/
	/*
	//if the profile activation is not null throw an error
	if($profile->getProfileActivationToken() !== null){
		throw (new \InvalidArgumentException ("you are not allowed to sign in unless you have activated your account", 403));
	} else {
	throw(new \InvalidArgumentException("Invalid HTTP method request."));
}
	*/

	// if an exception is thrown update the
} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
echo json_encode($reply);