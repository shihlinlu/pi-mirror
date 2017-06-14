
<div class="container tea">
	<div class="col-md-6">
		<!-- slack message -->
		<h1>Tea</h1>
		<div class="messages">

			<ul>
				<li *ngFor='let item of pubnub.getMessage(channel)'>
					{{item.message.user}} {{item.message.text}}
				</li>
			</ul>
		</div>
	</div>
</div>