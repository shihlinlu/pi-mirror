import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {Weather} from "../classes/weather";
import {BaseService} from "./base-service";

@Injectable()
export class WeatherService extends BaseService {
    constructor(protected http: Http) {
        super(http);
    }

    private weatherUrl = "api/weather/";

    getWeather() : Observable<Weather> {
        return(this.http.get(this.weatherUrl)
            .map(this.extractData)
            .catch(this.handleError));
    }
}