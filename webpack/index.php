<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<base href="<?php echo dirname($_SERVER["PHP_SELF"]) . "/"; ?>" />
		<script type="text/javascript" src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.10.0.min.js"></script>

		<title>Pi Mirror</title>
	</head>
	<body>
		<pi-mirror>Loading&hellip;</pi-mirror>
	</body>
</html>