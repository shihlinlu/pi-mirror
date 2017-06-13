
	<div class="container weather">
		<div class="col-sm-4">
			<h1>Albuquerque, NM</h1>
            <div class="clock">{{ myDate | date:'mediumTime' }}</div>

			<img src="images2/{{weather.icon}}">

			<div class="currently">
				<ul class="fa-ul">
					<li><i class="fa-li fa fa-clock-o"> </i>time: {{ weather.time | date }}</li>
					<li><i class="fa-li fa fa-thermometer-three-quarters"></i>temperature: {{ weather.temperature }}</li>
					<li><i class="fa-li fa fa-thermometer-full"></i>apparentTemperature: {{ weather.apparentTemperature }}</li>
					<li><i class="fa-li fa fa-skyatlas"></i>windSpeed: {{ weather.windSpeed }}</li>
					<li><i class="fa-li fa fa-mixcloud"></i>windBearing: {{ weather.windBearing }}</li>
					<li><i class="fa-li fa fa-sun-o"></i>Summary: {{ weather.summary }}</li>
				</ul>
			</div>
		</div> 
	</div>

