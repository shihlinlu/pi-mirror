
<div class="container tea">
	<div class="col-md-6">
		<!-- slack message -->
		<h1>Tea</h1>
		<div class="messages">

			<ul>
				<li *ngFor='let item of PubNub.getMessage(channel)'>{{item.message}}</li>
			</ul>
		</div>
	</div>
</div>