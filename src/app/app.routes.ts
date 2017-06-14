import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home-component";
import {WeatherService} from "./services/weather-service";
import {WeatherComponent} from "./components/weather-component";
import {SlackComponent} from "./components/slack-component";
import {SlackService} from "./services/slack-service";
import {TeaComponent} from "./components/tea-component";
import {TeaService} from "./services/tea-service";
import {PubNubAngular} from "pubnub-angular2";

export const allAppComponents = [HomeComponent, WeatherComponent, SlackComponent, TeaComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [WeatherService, SlackService, PubNubAngular, TeaService];

export const routing = RouterModule.forRoot(routes);