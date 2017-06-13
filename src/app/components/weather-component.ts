import {Component, OnInit} from "@angular/core";
import {WeatherService} from "../services/weather-service";
import {Weather} from "../classes/weather";

@Component({
    selector: "weather",
    templateUrl: "./templates/weather.php"
})

export class WeatherComponent implements OnInit {
    weather : Weather = new Weather(null, null, null, null, null, null, null);
    myDate: Date;
    constructor(protected weatherService: WeatherService) {}

    getWeather(): void {
        this.weatherService.getWeather()
            .subscribe(weather => this.weather = weather);
    }

    ngOnInit() : void {
        this.getWeather();
        this.utcTime();
    }
    utcTime(): void {
        setInterval(() => {
            this.myDate = new Date();
        }, 1000);
    }
}