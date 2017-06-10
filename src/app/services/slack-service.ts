import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {Slack} from "../classes/slack";
import {BaseService} from "./base-service";

@Injectable()
export class SlackService extends BaseService {
    constructor(protected http: Http) {
        super(http);
    }

    private slackUrl = "api/slack/";

    getSlack() : Observable<slack> {
        return(this.http.get(this.slackUrl)
            .map(this.extractData)
            .catch(this.handleError));
    }
}