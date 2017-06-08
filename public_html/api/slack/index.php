<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");

use Strime\Slackify\Api\Api;
use Strime\Slackify\Api\Channels;


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

/**
 * slack api call must have a method and parameter:
 * https://slack.com/api/channels.history?token=n&channel=n&count=n
 *
 **/

// if method is GET, handle the authentication to access Slack API methods
if ($method === "GET") {

	//$client = new \GuzzleHttp\Client();
	//$json_response = $client->request('GET', $this->getUrl(), []);
	//$response = \GuzzleHttp\json_decode($json_response->getBody() );
	//send request to slack API to receive channel history

	$api_channels_request = new Channels('slack2');
	$api_channels_request->history("C5BGUJ6R0", "",0,0,1);
	//return data// $reply->data = $api_channels_request;


}








