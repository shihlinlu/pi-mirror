import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home-component";
import {WeatherService} from "./services/weather-service";
import {WeatherComponent} from "./components/weather-component";
import {SlackComponent} from "./components/slack-component";
import {SlackService} from "./services/slack-service";
import {PubNubAngular} from "pubnub-angular2";

export const allAppComponents = [HomeComponent, WeatherComponent, SlackComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [WeatherService, SlackService, PubNubAngular];

export const routing = RouterModule.forRoot(routes);