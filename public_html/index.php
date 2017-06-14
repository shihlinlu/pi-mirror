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

		<title>Pi Mirror</title>
		<link href="dist/vendor.8fa53fcde0c9a011cdad.css" rel="stylesheet">
		<link href="dist/css.8fa53fcde0c9a011cdad.css" rel="stylesheet">
		<script type="text/javascript" src="dist/polyfills.8fa53fcde0c9a011cdad.js"></script>
		<script type="text/javascript" src="dist/vendor.8fa53fcde0c9a011cdad.js"></script>
		<script type="text/javascript" src="dist/app.8fa53fcde0c9a011cdad.js"></script>
		<script type="text/javascript" src="dist/css.8fa53fcde0c9a011cdad.js"></script>

	</head>
	<body>
		<pi-mirror>Loading&hellip;</pi-mirror>
	</body>
</html>