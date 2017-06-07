import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {Weather} from "../classes/weather";

@Injectable()
export class WeatherService {
    constructor(protected http: Http) {}

    private weatherUrl = "api/weather/";

    getWeather() : Observable<Weather> {
        return(this.http.get(this.weatherUrl)
            .map(response => response.json()));
    }
}