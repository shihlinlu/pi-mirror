
	<div class="container weather">
		<div class="col-sm-8">
			<h1>Weather in Albuquerque<i class="fa fa-sun-o fa-pulse fa-2p fa-fw"></i><span class="sr-only">Loading...</span></h1>

			<div class="currently">
				<ul class="fa-ul">
					<li><i class="fa-li fa fa-clock-o"> </i>time: {{ weather.time | date }}</li>
					<li><i class="fa-li fa fa-thermometer-three-quarters"></i>temperature: {{ weather.temperature }}</li>
					<li><i class="fa-li fa fa-thermometer-full"></i>apparentTemperature: {{ weather.apparentTemperature }}</li>
					<li><i class="fa-li fa fa-skyatlas"></i>windSpeed: {{ weather.windSpeed }}</li>
					<li><i class="fa-li fa fa-mixcloud"></i>windBearing: {{ weather.windBearing }}</li>
					<li><i class="fa-li fa fa-sun-o"></i>Summary: {{ weather.summary }}</li>
				</ul>
				<img src="images2/{{weather.icon}}">
			</div>
		</div>
	</div>

