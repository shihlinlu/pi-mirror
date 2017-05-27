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
//should it really be 200?
$reply->data = null;
//create stdClass named $reply. this object will be used to store the results of the call to the api. sets status to 200 (success). creates data state variable, holds the result of the api call.
try {
	//grab the mySQL database connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/piomirrors.ini");
	//determines which HTTP Method needs to be processed and stores the result in $method
	$method = array_key_exists("HTTP_x_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$tweetProfileId = filter_input(INPUT_GET, "tweetProfileId", FILTER_VALIDATE_INT);
	$tweetContent = filter_input(INPUT_GET, "tweetContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//stores the Primary key for the GET methods in $id, This key will come in the URL sent by the front end. If no key is present $id will remain empty. Note that the input filtered.

