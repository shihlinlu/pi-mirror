<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");


// start session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

// initialize encrypted config variable
$config = readConfig("/etc/apache2/capstone-mysql/piomirrors.ini");

// grab mySQL statement
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/piomirrors.ini");

// variable that will house the API key for Slack API
$slack2 = $config["slack2"];

// determine which HTTP method is being used
$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

// if method is GET, handle the authentication to access Slack API methods
if ($method === "GET") {

	/**
	 * slack api call must have a method and parameter:
	 * https://slack.com/api/<METHOD>?token=<API_TOKEN>(&<PARAMETER>=<VALUE>)
	 **/
	$json = 'https://slack.com/api/'.'$methodCall'.'$slack2'.'$param';
	$json = file_get_contents($json);
	$response = json_decode($json, true);

	if ($response != null) {

		// define variables to use slack's channels.history method
		$methodCall = $response['channels.history'];
		$param = $count['count'];

		// Latest message
		$type = $response['messages']['type'];
		$userId = $response['messages']['user'];
		$message = $response['messages']['text'];
		$timeStamp =$response ['messages']['ts'];
	}
}




