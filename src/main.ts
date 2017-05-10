import { platformBrowserDynamic } from "@angular/platform-browser-dynamic";
import { AppModule } from "./app/app.module";
//import { enableProdMode } from "@angular/core";

//only use when app is going live effects debugging
//enableProdMode();
platformBrowserDynamic().bootstrapModule(AppModule);