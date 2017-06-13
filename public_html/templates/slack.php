


<div class="container slack">
	<div class="col-md-6">
		<!-- slack message -->
		<h1>Slack</h1>
		<img src="images2/slack-logo.png" alt="slack-logo" style="max-height: 10rem">
		<div class="messages">

			<ul class="fa-ul">
				<li><i class="fa-li fa fa-user"></i>user: {{ slack.user }}</li>
				<li><i class="fa-li fa fa-envelope-o"></i>text: {{ slack.text }}</li>
				<li><i class="fa-li fa fa-clock-o"></i>time: {{ slack.ts | date: 'short' }}</li>
			</ul>
		</div>
	</div>
</div>