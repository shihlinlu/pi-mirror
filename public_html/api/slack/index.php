<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");


use CL\Slack\Payload\ChannelsHistoryPayload;


/**
 * API to display Slack channel history to the mirror
 *
 * @author Shihlin Lu
 **/

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

	// grab mySQL statement
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/piomirrors.ini");

	// variable that will house the API key for Slack API
	$slack2 = $config["slack2"];

	// determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];


	if ($method === "GET") {
		//set xsrf
		setXsrfCookie();

		// specify slack channel for message retrieval
		$payload = new ChannelsHistoryPayload();
		$payload->setChannelId('C5BGUJ6R0');

		$apiClient = new \CL\Slack\Transport\ApiClient("slack2");
		$response = $apiClient->send($payload);

		if($response->isOk()) {
			//channel with latest history
			$response->getLatest();
		} else {
			// error message
			echo $response->getError();

			// error explanation
			echo $response->getErrorExplanation();
		}

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

