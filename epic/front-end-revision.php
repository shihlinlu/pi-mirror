<!DOCTYPE html>
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

		
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        
		

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
		<!-- for skycons -->
<!--		<script src="javascript/skycons.js"></script>-->

		<!-- google fonts -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

		<!-- customer weather api call -->
	</head>
	<body onload="startTime()">


				<!-- weather -->
				<div class="col-md-3">
					<figure class="icons">

						<!-- these icons are thanks to the creators at skycon http://darkskyapp.github.io/skycons/ -->

						<canvas id="clear-day" width="64" height="64">-->
						</canvas>

						<canvas id="clear-night" width="64" height="64">
						</canvas>

						<canvas id="partly-cloudy-day" width="64" height="64">
						</canvas>
						<canvas id="partly-cloudy-night" width="64" height="64">

						</canvas>
						<canvas id="cloudy" width="64" height="64">
						</canvas>

						<canvas id="rain" width="64" height="64">--></canvas>

						<canvas id="sleet" width="64" height="64">
						</canvas>

						<canvas id="snow" width="64" height="64">
						</canvas>

						<canvas id="wind" width="64" height="64">
						</canvas>

						<canvas id="fog" width="64" height="64">
						</canvas>
					</figure>
				</div>




			<!-- code for clock & weather icons in javascript placed in footer to load in a timely manner -->
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

	<!--code for the weather icons  -->

</script>
			<div class="icons">
				<!-- from github.com/darkskyapp/skycons/blob/master/index.html -->
				<script src="javascript/skycons.js"></script>
<script>
	var icons = new Skycons({"color": "#ffffff"}),
		list  = [
			"clear-day", "clear-night", "partly-cloudy-day",-->
			"partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
			"fog"
		],
		i;
	for(i = list.length; i--; )
		icons.set(list[i], list[i]);
	icons.play();

</script>

			</div>

			</footer>
    </body>
</html>