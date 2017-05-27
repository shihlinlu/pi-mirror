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
//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	<?php
if($method === "GET") {
	//set XSRF cookie
	setXsrfCookie();

	//get a specific tweet based on arguments provided or all the tweets and update reply
	if(empty($id) === false) {
		$tweet = Tweet::getTweetByTweetId($pdo, $id);
		if($tweet !== null) {
			$reply->data = $tweet;
		}
	} else if(empty($tweetProfileId) === false) {
		$tweet = Tweet::getTweetByTweetProfileId($pdo, $tweetProfileId)->toArray();
		if($tweet !== null) {
			$reply->data = $tweet;
		}
	} else if(empty($tweetContent) === false) {
		$tweets = Tweet::getTweetByTweetContent($pdo, $tweetContent)->toArray();
		if($tweets !== null) {
			$reply->data = $tweets;
		}
	} else {
		$tweets = Tweet::getAllTweets($pdo)->toArray();
		if($tweets !== null) {
			$reply->data = $tweets;
		}
	}