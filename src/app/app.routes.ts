import {RouterModule, Routes} from "@angular/router";
import {BaconComponent} from "./components/bacon-component";
import {HomeComponent} from "./components/home-component";
import {BaconService} from "./services/bacon-service";
import {WeatherService} from "./services/weather-service";
import {WeatherComponent} from "./components/weather-component";
import {SlackComponent} from "./components/slack-component";
import {SlackService} from "./services/slack-service";

export const allAppComponents = [BaconComponent, HomeComponent, WeatherComponent, SlackComponent];

export const routes: Routes = [
	{path: "bacon", component: BaconComponent},
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [BaconService, WeatherService, SlackService];

export const routing = RouterModule.forRoot(routes);