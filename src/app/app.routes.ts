import {RouterModule, Routes} from "@angular/router";
import {BaconComponent} from "./components/bacon-component";
import {HomeComponent} from "./components/home-component";
import {BaconService} from "./services/bacon-service";
import {WeatherService} from "./services/weather-service";
import {WeatherComponent} from "./components/weather-component";

export const allAppComponents = [BaconComponent, HomeComponent, WeatherComponent];

export const routes: Routes = [
	{path: "bacon", component: BaconComponent},
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [BaconService, WeatherService];

export const routing = RouterModule.forRoot(routes);