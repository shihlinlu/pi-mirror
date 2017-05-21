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

		<title>Front End- Static</title>
	</head>
	<body>
		<!-- container for the page -->
		<div class="container">
			<div class="row">
				<div class="col-md-6 text-center">
					<h1>
						Pi-Mirror
					</h1>
				</div>
				<div class="col-md-6 text-right">
					<img src="images/date.png" alt="date">
					<img src="images/time.png" alt="time">
				</div>
			</div>
			<!-- to do list code -->
			<div class="row pad-down">
			<div class="form-group col-md-6">
				<h1>To-Do
					<small>List</small>
				</h1>
				<form role="form">
					<input type="text" class="form-control" placeholder="Your Task" name="task">
				</form>
				<button type="button" class="btn btn btn-primary">Add</button>
			</div>
				<div class="col-md-6">
					<p>Slack this</p>
					<p>Slack that</p>
					<p>Slack you</p>
				</div>
			</div>
			<div class="row pad-down ">
				<div class="col-md-6">
					<p>This will be a list -  senors that go "DETECT DETECT DETECT"</p>
					<table class="table table-hover">
						<tr>
							<th>oxygen</th>
							<th>Humidity</th>
						</tr>
						<tr>
							<td>EXAMPLE</td>
							<td>EXAMPLE</td>
						</tr>
						<tr>
							<td>EXAMPLE</td>
							<td>EXAMPLE</td>
						</tr>
					</table>
				</div>
				<div class="col-md-6">
					<img src="images/notification.jpeg">
				</div>
			</div>
			<div class="row pad-down">
				<div class="col-md-6">
					<img src="images/gusty.png">
				</div>
				<div class="col-md-6">
					<h1>Weather Data</h1>
					<ul>
						<li>WINDY AS TITAN'S GAS</li>
						<li>HOT AS HADES</li>
						<li>CHANCE OF CATCHING ZEUS' WRATHS</li>
					</ul>
				</div>
			</div>
	</body>
</html>