<h1>Weather in Albuquerque</h1>
    <div class="currently">
        <div class="col-md-6">
            <ul>
                <li>time: {{ weather.time | date }}</li>
                <li>temperature: {{ weather.temperature }}</li>
                <li>apparentTemperature: {{ weather.apparentTemperature }}</li>
                <li>windSpeed: {{ weather.windSpeed }}</li>
                <li>windBearing: {{ weather.windBearing }}</li>
                <li>Summary: {{ weather.summary }}</li>
            </ul>
        </div>
    </div>