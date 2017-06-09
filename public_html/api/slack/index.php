<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");

use Strime\Slackify\Api\Channels;

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

// grab mySQL statement
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/piomirrors.ini");

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

		if(empty($id) === false) {
			$message = Channels::$channel($pdo, $channel);
			if($message !== null) {
				$reply->data = $message;
			}
		}

		$message = new Channels("slack2");
		$channel = $message->history("C5BGUJ6R0","1496875875.195638", 0, 0, 1, 0);

		//if(empty($channel->ok) === true ) {
			//throw new \RuntimeException("Can't get message.", $channel->status);
		//}

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




















