import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home-component";
import {WeatherService} from "./services/weather-service";
import {WeatherComponent} from "./components/weather-component";
import {SlackComponent} from "./components/slack-component";
import {SlackService} from "./services/slack-service";
import {ClockService} from "./services/clock-service";
import {ClockComponent} from "./components/clock-component";

export const allAppComponents = [HomeComponent, WeatherComponent, SlackComponent, ClockComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [WeatherService, SlackService, ClockService];

export const routing = RouterModule.forRoot(routes);