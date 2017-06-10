import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";

@Injectable()
export class BaconService {
	constructor(protected http: Http) {}

	private baconUrl = "https://darksky.net/forecast/35.0585,-106.6236/us12/en";

	getBacon(paragraphs : number) : Observable<string[]> {
		return(this.http.get(this.baconUrl + paragraphs)
			.map(response => response.json()));
	}
}