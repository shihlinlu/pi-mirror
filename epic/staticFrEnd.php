<!DOCTYPE html>
<html>
	<head>

	</head>

	<title>
		Static Front end
	</title>
	<body>
			<!-- container for the page -->
			<div class="container">

			<div class="col-lg-8 text-center">

			</div>
			<div class="row">


				<div class="col-lg-12 text-offset">
					<h1>Demo</h1>
				</div>
			</div>
			<main>
				<div class="row">
					<div class= "col-md-2 col-md-offset-5">
					<img src="images/clock.jpeg" alt="clock">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-1">
						<img src="images/conditions.jpeg" alt="conditions">
					</div>
					<div class="notif">
						<p>(Notification about air)</p>
						<img src="images/notification.jpeg" alt="notifications">
					</div>
				</div>

				<div class="greeting" alt="greeting">
					<em> Good Morning Pi Group</em>
				</div>

				<div class="feed">
					<img src="images/todolist.jpeg" alt="todolist">
					<img src="images/slack.jpeg" alt="slack">
				</div>

                <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
                <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
                <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

                <body>
                <div class="form-group">
                    <h1>To-Do <small>List</small></h1>
                    <form role="form">
                        <input type="text" class="form-control" placeholder="Your Task" name="task">
                    </form>
                    <button type="button" class="btn btn btn-primary">Add</button>
                </div>
                <div></div>
                <ul class="list-unstyled" id="todo"></ul>
                </body>
			</main>
		</div>
	</body>
</html>