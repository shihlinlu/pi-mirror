<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!--font awesome for icons and stuff-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<!-- for mobile view -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
				integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
				integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->
		<!-- HTML5 shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!-- [if lt IE9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- Custom CSS -->
		<link rel="stylesheet" href="css/style2.css" type="text/css"/>

		<!-- jQuery v3.0 -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js" type="text/javascript"></script>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
				  integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
				  crossorigin="anonymous"></script>

		<title>Pi-mirror</title>

		<!--custom javscript link for front end -->
		<script src="javascript/script.js" type="text/javascript"></script>

		<!-- customer weather api call -->
		<link rel="api-call" href="../public_html/api/weather/index.php"/>

	</head>


	<body onload="startTime()">

		<!-- container for the page -->
		<div class="container">
			<div class="row">
				<!-- notification section -->
				<div class="col-md-3">
					<i class="fa fa-sun-o"></i>
					<p>80 degrees and sunny</p>
				</div>
				<div class="col-md-4" id="welcome">
					<!-- welcome message -->
					<h1>
						Good Evening
					</h1>
				</div>
				<!-- date, time, and weather section -->
					<div class="col-md-3" id="time">
				<!-- code for time show the time -->
						<div class="container">
							<script type="text/javascript">

							</script>
						</div>

					</div> <!-- colunm -->
				</div> <!-- row 1 -->

				<div class="row">
					<div class="container" id="slack">
						<div class="col-md-12">
							<!-- slack goes here with angular-->

						</div>
					</div> <!-- container -->
				</div> <!-- row2 for slack -->
			</div>
		<footer>
<script>
	function startTime() {
		var today = new Date();
		var h = today.getHours();
		var m = today.getMinutes();
		var s = today.getSeconds();
		var M = today.getMonth();
		var d = today.getDate();
		var y = today.getFullYear();
		m = checkTime(m);
		s = checkTime(s);
		document.getElementById('time').innerHTML =
			h + ":" + m + ":" + s + "<br>" + M + "/" + d + "/" + y;
		var t = setTimeout(startTime, 500);
	}
	function checkTime(i) {
		if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
		return i;
	}
</script>
			<div class="api-call">
				<?php
				echo ($ngWeather);
				?>
			</div>
		</footer>

	</body>
</html>