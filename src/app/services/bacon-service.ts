import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";

@Injectable()
export class BaconService {
	constructor(protected http: Http) {}

	private baconUrl = "https://baconipsum.com/api/?type=meat-and-filler&paras=";

	getBacon(paragraphs : number) : Observable<string[]> {
		return(this.http.get(this.baconUrl + paragraphs)
			.map(response => response.json()));
	}
}