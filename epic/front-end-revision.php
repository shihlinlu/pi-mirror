<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
				integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
				integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<!-- HTML5 shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!-- [if lt IE9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- Custom CSS -->
		<link rel="text/css" href="css/style.css" type="text/css"/>
		<!-- jQuery v3.0 -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js" type="text/javascript"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
				  integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
				  crossorigin="anonymous"></script>
		<!-- as of Saturday May 20th, it was noticed that css was not effecting anything -->
		<title>Front End- Static</title>
	</head>
	<body>
		<!-- container for the page -->
		<div class="container">
			<div class="row">
				<!-- notification section -->
				<div class="col-md-3">
					<img src="images/notification.png" class="inverted">
				</div>
				<div class="col-md-4 text-right">
					<!-- welcome message -->
					<h1>
						Good Evening
					</h1>
				</div>
				<!-- date, time, and weather section -->
				<div class="col-md-3 col-md-offset-2 col-xs-4 col-xs-offset-4">
					<img src="images/date.png" alt="date" width="200" height="200" class="inverted">
					<img src="images/time.png" class="float-right" alt="time" width="200" height="200" class="inverted">
					<img src="images/gusty.png" width="200" height="200" class="inverted">
				</div>
			</div>
			<!-- to do list -->
			<div class="row pad-down">
				<div class="form-group col-md-3 col-md-offset-9">
					<h1>To-Do
						<small>List</small>
					</h1>
					<form role="form">
						<input type="text" class="form-control" placeholder="Your Task" name="task">
					</form>
					<button type="button" class="btn btn btn-primary">Add</button>
				</div>
				<!-- Insert slack feed here -->
				<div class="col-md-6 col-md-offset-6 text-right">
					<p>Slack this</p>
					<p>Slack that</p>
					<p>Slack you</p>
				</div>
			</div>

		</div>
	</body>
</html>