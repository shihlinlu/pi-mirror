<?php
require_once dirname(__DIR__,3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * api to display Slack channel events to the mirror
 *
 * @author Shihlin Lu
 * @author Luc Flynn
 **/

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	// start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	// grab mySQL statement
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/piomirrors.ini");

	// determine which HTTP method is being used


}

