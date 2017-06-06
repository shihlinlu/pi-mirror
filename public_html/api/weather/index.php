<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");



use Forecast\Forecast;
/**
 * api for current weather
 *
 * @authors Tucker & Luc (Github)
 **/

//start session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;




try {
	
	//initialize encrypted config variable
	//config is reading
	//although the name does not match the database this is correct per bridge's example
	$config = readConfig("/etc/apache2/capstone-mysql/piomirrors.ini");
	
	//variable that will house the API key for the Dark Sky API
	$darkSky = $config["darkSky"];
	
	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	
	
	
	
	//If method is get handle the sign in logic
	if ($method === "GET") {
		//set xsrf
		setXsrfCookie();
		
		if(empty($id) === false) {        
			$forecast = Forecast::$weather($pdo, $weather);
			if($forecast !== null ) {
				$reply->data = $weather;
			}
		}
		
		$forecast = new Forecast($darkSky);
		
		$weather = $forecast->get(35.0803, -106.6056);
		     //$reply->data=$weather;
		//v  ar_dump($weather);
		
		
		if(empty($weather->currently) === true ) {
			throw new \RuntimeException("Unsure about whether or not we can get the weather", $weather->status);
		}
		
		$ngWeather = new stdClass();
		
		$ngWeather->time = $weather->currently->time;
		$ngWeather->temperature = $weather->currently->temperature;
		$ngWeather->apparentTemperature = $weather->currently->apparentTemperature;
		$ngWeather->windSpeed = $weather->currently->windSpeed;
		$ngWeather->windBearing = $weather->currently->windBearing;
		$reply->data = $ngWeather;
		
	} else {
		throw (new \InvalidArgumentException("invalid http method request"));
		
		
		// if an exception is thrown update the
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