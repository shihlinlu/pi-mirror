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

		<!-- customer weather api call -->
       
		
		
	</head>
    
	<body onload="startTime()">

		<!-- container for the page -->
		<div class="container" id="weather">
			<div class="row">
				<!-- weather -->
				<div class="col-md-3">
					<figure class="icons">
						<!-- these icons are thanks to the creators at skycon http://darkskyapp.github.io/skycons/ -->

						<canvas id="clear-day" width="64" height="64">
						</canvas>

						<canvas id="clear-night" width="64" height="64">
						</canvas>

						<canvas id="partly-cloudy-day" width="64" height="64">
						</canvas>

						<canvas id="partly-cloudy-night" width="64" height="64">
						</canvas>

						<canvas id="cloudy" width="64" height="64">
						</canvas>

						<canvas id="rain" width="64" height="64">
						</canvas>

						<canvas id="sleet" width="64" height="64">
						</canvas>

						<canvas id="snow" width="64" height="64">
						</canvas>

						<canvas id="wind" width="64" height="64">
						</canvas>

						<canvas id="fog" width="64" height="64">
						</canvas>
					</figure>
					<!-- php text to grab weather and echo to front end -->
			<div ngClass="weather">
				<?php

				?>
			</div>
				</div>
				<div class="col-md-4" id="welcome">
					<!-- slack message -->
					<h1>Slack</h1> <i class="fa fa-slack fa-4x"></i>
					<div class="messages">
						<div class="col-md-6">
							<p>user: me</p>
							<p>message: =)</p>
						</div>
					</div>
				</div>
				<!-- date, time, and weather section -->
					<div class="col-md-3" id="time">
				<!-- code for time / show the time -->
						<div class="container">
							<script type="text/javascript">

							</script>
						</div>

					</div> <!-- column -->
				</div> <!-- row 1 -->

				<div class="row">
					<div class="container" id="slack">
						<div class="col-md-12">
							<!-- slack goes here with angular-->
                            <div ngClass="weather">
                           
                            </div>

						</div>
					</div> <!-- container -->
				</div> <!-- row2 for slack -->
			</div>
		<footer>
			<!-- this is temporary we will add it to a js file later we jut want a proof of concept  -->
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
			<div class="icons">
				<!-- from github.com/darkskyapp/skycons/blob/master/index.html -->
				<script src="javascript/skycons.js"></script>
<script>

	var icons = new Skycons({"color": "#ffffff"}),
		list  = [
			"clear-day", "clear-night", "partly-cloudy-day",
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