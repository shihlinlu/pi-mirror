import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";

@Injectable()
export class TeaService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private teaUrl = "api/tea/";

	getSlack() : Observable<Tea> {
		return(this.http.get(this.teaUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}
}