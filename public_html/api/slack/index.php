<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");

/**
 * API for Slack Channel Feed
 *
 * Author: Shihlin Lu
 */
// start session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// initialize encrypted config variable
	$config = readConfig("/etc/apache2/capstone-mysql/piomirrors.ini");

// variable that will house the API key for Slack API
	$slack2 = $config["slack2"];

// determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	/**
	 * slack api call must have a method and parameter:
	 * https://slack.com/api/channels.history?token=n&channel=n&count=n
	 *
	 **/

// if method is GET, handle the authentication to access Slack API methods
	if($method === "GET") {
		//set xsrf
		setXsrfCookie();

		// Specific channel id
		$channelId = 'C5BGUJ6R0';
		$guzzle = new GuzzleHttp\Client();

		//
		$message = getSlackMessages($channelId, $guzzle, $config)[0];

		$userId = $message->user;

		$userData = getSlackUserData($userId, $guzzle, $config);

		// replace the userId from getSlackMessages request with username from getSlackUserData request
		$message->user = $userData->name;
		$message->ts = $message->ts * 1000;

		$reply->data = $message;

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


// Get the latest message from Slack channel utilizing the channels.history API method call
function getSlackMessages($channelId, $guzzle, $config){
	$messagesUrl = "https://slack.com/api/channels.history?token=" . $config["slack2"] . "&channel=". $channelId ."&count=1";
	$messagesResult = $guzzle->get($messagesUrl);

	if($messagesResult->getStatusCode() !== 200) {
		throw(new \RuntimeException("can't get to Slack", $messagesResult->getStatusCode()));
	}
	// Decode the json object to target the message array
	$messages = json_decode($messagesResult->getBody())->messages;

	return $messages;
}

// Get the username from Slack utilizing the users.info API method call
function getSlackUserData($userId, $guzzle, $config){
	$userDataUrl = "https://slack.com/api/users.info?token=" . $config["slack2"] . "&user=" . $userId;
	$userDataResult = $guzzle->get($userDataUrl);

	if($userDataResult->getStatusCode() !== 200) {
		throw(new \RuntimeException("can't get to Slack", $userDataResult->getStatusCode()));
	}

	$userData = json_decode($userDataResult->getBody())->user;

	return $userData;
}














